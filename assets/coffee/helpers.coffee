delay = (time, callback) -> setTimeout callback, time
addMessage = (type, message, ms) ->
  $alert = jQuery(document.createElement('div')).attr('class', "alert alert-#{type}").html(message).hide()
  $alert.appendTo(jQuery('#messages'))
  $alert.slideDown()
  offsets = $alert.offset()
  window.scrollTo(offsets.top, offsets.left)
  delay ms, ->
    $alert.slideUp ->
      $alert.remove()
