class AdminProductVariable
  params:
    ajax: ''

  constructor: (@params) ->
    jQuery('#product-type').on 'change', @removeParameters

  removeParameters: (event) ->
    $item = jQuery(event.target)
    if $item.val() == 'variable'
      jQuery('.product_regular_price_field').slideUp()

jQuery ->
  new AdminProductVariable(jigoshop_admin_product_variable)
