<?php
/*
Template Name: Character List
*/
get_header();

// Fetch characters from DB
$args = array(
    'post_type' => 'character',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
);
$query = new WP_Query($args);

$characters = [];
$total_characters = $query->found_posts;

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        
        $name = get_the_title();
        $first_letter = strtoupper(substr($name, 0, 1));
        if(!preg_match('/^[A-Z]$/', $first_letter)) {
            $first_letter = '#';
        }

        $image = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
        if(!$image) {
            $image = $first_letter;
        }

        $characters[$first_letter][] = [
            'name' => $name,
            'series' => get_post_meta(get_the_ID(), '_character_series', true),
            'category' => get_post_meta(get_the_ID(), '_character_category', true),
            'alias' => get_post_meta(get_the_ID(), '_character_alias', true),
            'score' => get_post_meta(get_the_ID(), '_character_score', true) ?: 0,
            'image' => $image,
        ];
    }
    wp_reset_postdata();
}

$alphabet = range('A', 'Z');
$alphabet[] = '#';
?>

<style>
/* Character List Page Styles */
.char-page-container { max-width: 1280px; margin: 0 auto; padding: 2rem 2rem 5rem; background: #f8f9fa; min-height: 100vh; font-family: 'Outfit', sans-serif; }
.char-breadcrumb { font-size: 0.9rem; color: #666; margin-bottom: 2rem; }
.char-breadcrumb a { color: #333; text-decoration: none; font-weight: 500; }
.char-search-wrapper { margin-bottom: 1.5rem; }
.char-search-wrapper input { width: 100%; padding: 1rem 1.5rem; font-size: 1rem; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); outline: none; transition: box-shadow 0.2s; border-left: 4px solid #777; }
.char-search-wrapper input:focus { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.char-alphabet-filter { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 2rem; }
.char-letter-btn { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #fff; border: 1px solid #eaeaea; border-radius: 8px; color: #555; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.char-letter-btn:hover { background: #f0f0f0; color: #333; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
.char-stats-summary { background: #fff5f5; color: #555; padding: 1rem; border-radius: 8px; border: 1px solid #ffebeb; margin-bottom: 3rem; font-size: 0.95rem; }
.char-group { margin-bottom: 4rem; }
.char-group-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #333; display: flex; align-items: center; gap: 10px; }
.char-group-title::before { content: ''; display: block; width: 4px; height: 24px; background: #F28C8C; }
.char-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
.char-card { background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); display: flex; flex-direction: column; gap: 1rem; transition: transform 0.2s, box-shadow 0.2s; border: 1px solid #f0f0f0; }
.char-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
.char-card-top { display: flex; align-items: center; gap: 1rem; }
.char-avatar { width: 60px; height: 60px; border-radius: 12px; overflow: hidden; background: #e9ecef; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.char-avatar img { width: 100%; height: 100%; object-fit: cover; }
.char-avatar-initial { font-size: 1.5rem; font-weight: 700; color: #495057; }
.char-info { flex: 1; }
.char-name { font-size: 1.1rem; font-weight: 700; margin: 0 0 4px 0; color: #222; }
.char-series { font-size: 0.85rem; color: #6c757d; margin: 0; }
.char-score { background: #f1f3f5; color: #495057; font-size: 0.8rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; align-self: flex-start; }
.char-card-middle { margin-top: 0.5rem; }
.char-badge { background: #e7f1ff; color: #6b8dbb; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; display: inline-block; }
.char-card-bottom { margin-top: auto; padding-top: 1rem; border-top: 1px dashed #eaeaea; }
.char-card-bottom.empty-alias { border-top: none; padding-top: 0; }
.char-alias-badge { color: #888; font-size: 0.8rem; }
</style>

<div class="char-page-container">

    <!-- Search Box -->
    <div class="char-search-wrapper">
        <input type="text" id="char-search-input" placeholder="Tìm kiếm nhân vật hoặc tên gọi khác..." />
    </div>

    <!-- Alphabet Filter -->
    <div class="char-alphabet-filter">
        <?php foreach($alphabet as $letter): ?>
            <a href="#letter-<?php echo $letter; ?>" class="char-letter-btn"><?php echo $letter; ?></a>
        <?php endforeach; ?>
    </div>

    <!-- Stats summary -->
    <div class="char-stats-summary">
        Đang hiển thị <strong><?php echo $total_characters; ?> characters</strong> trong database.
    </div>

    <!-- Character List Grouped -->
    <?php foreach($alphabet as $letter): ?>
        <?php if(!empty($characters[$letter])): ?>
            <div class="char-group" id="letter-<?php echo $letter; ?>">
                <h2 class="char-group-title"><?php echo $letter; ?></h2>
                <div class="char-grid">
                    <?php foreach($characters[$letter] as $char): 
                        // Count products matching this character
                        $prod_query = new WP_Query([
                            'post_type' => 'product',
                            's' => $char['name'],
                            'posts_per_page' => 1,
                            'fields' => 'ids'
                        ]);
                        $product_count = $prod_query->found_posts;
                        $search_url = home_url('/?s=' . urlencode($char['name']) . '&post_type=product&from_char=1');
                    ?>
                        <a href="<?php echo esc_url($search_url); ?>" class="char-card" style="text-decoration: none; color: inherit;">
                            <div class="char-card-top">
                                <div class="char-avatar">
                                    <?php if(strlen($char['image']) == 1): ?>
                                        <span class="char-avatar-initial"><?php echo $char['image']; ?></span>
                                    <?php else: ?>
                                        <img src="<?php echo $char['image']; ?>" alt="<?php echo esc_attr($char['name']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="char-info">
                                    <h3 class="char-name"><?php echo esc_html($char['name']); ?></h3>
                                    <p class="char-series"><?php echo esc_html($char['series']); ?></p>
                                </div>
                                <div class="char-score" title="Số lượng sản phẩm">
                                    <?php echo $product_count; ?>
                                </div>
                            </div>
                            <?php if(!empty($char['category'])): ?>
                            <div class="char-card-middle">
                                <span class="char-badge"><?php echo esc_html($char['category']); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="char-card-bottom <?php echo empty($char['alias']) ? 'empty-alias' : ''; ?>">
                                <?php if(!empty($char['alias'])): ?>
                                    <span class="char-alias-badge"><?php echo esc_html($char['alias']); ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if($total_characters == 0): ?>
        <p>Chưa có nhân vật nào trong cơ sở dữ liệu. Hãy thêm nhân vật từ trang quản trị WordPress!</p>
    <?php endif; ?>
</div>

<script>
    // Basic search filtering
    document.getElementById('char-search-input').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let cards = document.querySelectorAll('.char-card');
        cards.forEach(card => {
            let name = card.querySelector('.char-name').textContent.toLowerCase();
            let series = card.querySelector('.char-series').textContent.toLowerCase();
            let aliasElem = card.querySelector('.char-alias-badge');
            let alias = aliasElem ? aliasElem.textContent.toLowerCase() : '';
            
            if(name.includes(val) || series.includes(val) || alias.includes(val)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Hide empty groups
        let groups = document.querySelectorAll('.char-group');
        groups.forEach(group => {
            let visibleCards = group.querySelectorAll('.char-card[style="display: flex;"], .char-card:not([style*="display: none"])');
            if(visibleCards.length === 0 && val !== '') {
                group.style.display = 'none';
            } else {
                group.style.display = 'block';
            }
        });
    });
</script>

<?php get_footer(); ?>
