<?php


$call = Call::find($_GET['id'])
if ($call->update(get_params($call_params))) {
  redirect_to($call->url(), ['success'=>'Call updated!']);
} else {
  render('edit.php', ['error'=>'there was a problem updating that call']);
}

function get_params($allowed_fields=[]) {
  $_REQUEST & $allowed_fields
}
