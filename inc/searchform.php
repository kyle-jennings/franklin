<?php



function franklin_searchform() {
    ob_start();
    $franklin_search = franklin_digital_search();
?>
<form role="search" method="get" class="usa-search usa-search-small js-search-form"
    action="<?php echo $franklin_search['action']; ?>">
  <div role="search">
    <label class="usa-sr-only" for="search-field-small">
        <?php echo _x( 'Search for:', 'search lable', 'franklin' ); ?>
    </label>

    <input id="search-field-small" type="search" name="<?php echo $franklin_search['name']; ?>"
    placeholder="<?php echo esc_attr_x( 'Search ...', 'placeholder', 'franklin' ); ?>"
    value="<?php echo get_search_query() ?>" name="s"
    title="<?php echo esc_attr_x( 'Search for:', 'title','franklin' ) ?>" />

    <?php echo $franklin_search['hidden']; ?>

    <button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'franklin' ); ?>">
      <span class="usa-sr-only">Search</span>
    </button>
  </div>
</form>
<?php
$contents = ob_get_contents();
ob_end_clean();

return $contents;
}

add_filter( 'get_search_form', 'franklin_searchform');
