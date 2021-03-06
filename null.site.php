<?php
// Captures the contents Wordpress get_header() method.
function NullHeader() {
    ob_start();
    get_header();
    $header = ob_get_contents();
    ob_end_clean();

    return $header;
}

function NullFooter(){
    ob_start();
    get_footer();
    $footer = ob_get_contents();
    ob_end_clean();
    return $footer;
}

function NullHeroText($text) {
  return NullTag('div', $text, array('class' => 'hero'));
}

function NullSectionTitle($content) {
  return NullTag('h2', $content);
}

function NullTitleTag() {
  $siteTitle = get_bloginfo('name');
  if (is_home()) {
    return $siteTitle;
  }

  $pageTitle = '';
  if (is_single() || is_page()) {
    $pageTitle = getPostTitle();
  } elseif (is_archive()) {
    $pageTitle = getArchiveTitle();
  } elseif (is_search()) {
    $pageTitle = 'Search';
  } else {
    return $siteTitle;
  }

  return $pageTitle . ' | ' . $siteTitle;
}

function NullSiteTitle($wrap=true) {
    $siteTitle = getSiteTitle();
    $linkTitle = esc_attr( get_bloginfo( 'name', 'display' ) );
    $siteUrl = esc_url( home_url( '/' ) );

    $linkAttr = array(
        'href' => $siteUrl,
        'title' => $linkTitle,
        'rel' => 'home'
        );
    $link = NullTag('a', $siteTitle, $linkAttr);
    if (!$wrap) return $link;
    return NullTag('h1', $link);
}

function getSiteTitle() {
  return get_bloginfo('name');
}

function NullSiteDescription() {
    return NullTag('p', get_bloginfo('description'));
}

function NullGoogleAnalytics($account) {
    if ($account == '') { return ''; }

    $ga = '';
    $ga = $ga.'<script type="text/javascript">';
    $ga = $ga.'var _gaq = _gaq || [];';
    $ga = $ga."_gaq.push(['_setAccount', '".$account."']);";
    $ga = $ga."_gaq.push(['_trackPageview']);";
    $ga = $ga.'(function() {';
    $ga = $ga."  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
    $ga = $ga."  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
    $ga = $ga."  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
    $ga = $ga."})();";
    $ga = $ga.'</script>';
    return $ga;
}

function NullBodyClass(){
    $classes = get_body_class();
    return implode(" ", $classes);
}

function NullIsFrontPage() {
  return is_front_page();
}

function NullIsArchive() {
  return is_archive();
}

function NullSiteCategories() {
  $categories = get_categories();

  $list = "";
  foreach ($categories as $category) {
    $list .= NullTag('li',
      NullLink($category->cat_name, esc_url( get_category_link( $category->term_id ) )),
      array('class' => 'category')
    );
  }

  return NullTag('ul', $list, array('class' => 'categories'));
}

function NullBodyOpen() {
  $klass = NullBodyClass();
  return '<body class="'.$klass.'">';
}

function NullBodyClose() {
  return '</body>';
}

// Force a 404 page. Can be used in the midst of any other page.
function Null404() {
  status_header( 404 );
  nocache_headers();
  include( get_query_template( '404' ) );
  die();
}
?>
