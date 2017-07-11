<?php
$errors = array();

function field_name_as_text($fieldname) {
  $fieldname = str_replace("_", " ",$fieldname);
  $fieldname = ucfirst($fieldname);
  return $fieldname;
}
// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value) {
	return isset($value) && $value !== "";
}

function validate_presences($required_fields){
  global $errors;
  foreach ($required_fields as $field){
    $value = trim($_POST[$field]);
    //if has presence value returns 'false'
    if(!has_presence($value)) {
      $errors[$field] = field_name_as_text($field) . " can't be blank";
    }
  }
}

// * string length
// max length
function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
	  if (!has_max_length($value, $max)) {
	    $errors[$field] = field_name_as_text($field) . " is too long";
	  }
	}
}

// * string length
// min length
function has_min_length($value, $min) {
	return strlen($value) >= $min;
}

function validate_min_lengths($fields_with_min_lengths) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_min_lengths as $field => $min) {
		$value = trim($_POST[$field]);
	  if (!empty($value) && !has_min_length($value, $min)) {
	    $errors[$field] = field_name_as_text($field) . " requires at least " . $min . " characters";
	  }
	}
}

// * inclusion in a set
function has_inclusion_in($value, $set) {
	return in_array($value, $set);
}

function user_not_in_set(){
  global $errors;
  $current_user = trim($_POST["username"]);
  $user_array = array();
  $user_set = find_all_usernames();
  while($user_list = mysqli_fetch_array($user_set)){
    $user_array[] = $user_list["username"];
  }
  $result = has_inclusion_in($current_user, $user_array);
  if($result){
    $errors["exists"] = "user name already exists";
      }

}

function field_has_no_whitespace($fields_with_no_whitespace){
  global $errors;
    // Expects an assoc. array
  foreach($fields_with_no_whitespace as $field) {
  $text = trim($_POST[$field]);
    if(preg_match('/\s/',$text)){
      $errors[$field] = field_name_as_text($field) . " cannot contain spaces";
    }
  }
}

function fields_are_equal($value1, $value2){
  global $errors;
	// Expects an assoc. array
	 $comp1 = trim($_POST[$value1]);
   $comp2 = trim($_POST[$value2]);
    if($comp1 != $comp2){
      $errors["new password confirm"] = "password fields are not equal";
    }
    return $errors;
}

//==========file upload validations=======/
function check_file_errors($files){
  global $errors;
  foreach($files as $key => $file){
    if($file["error"]!=0){
    switch ($file["error"]) {
            case UPLOAD_ERR_INI_SIZE:
                $errors["system-error"] = "{$key} - {$file["name"]} exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $errors["system-error"] = "{$key} - {$file["name"]} exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $errors["system-error"] = "{$key} - {$file["name"]} was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $errors["system-error"] = "{$key} is missing file";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $errors["system-error"] = "System error: Missing a temporary folder, contact administrator";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $errors["system-error"] = "System error: Failed to write file to disk, contact administrator";
                break;
            case UPLOAD_ERR_EXTENSION:
                $errors["system-error"] = "System error: File upload stopped by extension, contact administrator";
                break;
            default:
                $errors["system-error"] = "Unknown upload error, contact administrator";
                break;
              } //end switch
              return $formOK = false;
      }//end if
    }//end for each

  } //end function

function validate_extensions($files){
  global $errors;
  foreach($files as $key => $file){
    $fileExt = pathinfo($file["name"], PATHINFO_EXTENSION);
    $imgExt = array("jpg", "jpeg", "png", "gif", "JPG", "JPEG");
    if($key == "vcard" && $fileExt!="vcf"){
      $errors["vcard"] = "{$key} - {$file["name"]} is not a .vcf file";
      $formOK = false;
    } elseif($key == "bizimage" && !in_array($fileExt, $imgExt)){
      $errors["bizimage"] = "{$key} - {$file["name"]} is not a .jpg, .jpeg, .png, or .gif file";
      $formOK = false;
    } else { $formOK=true;}
  }//end for each loop
  return $formOK;
}

function validate_vcard($vcard){
  global $errors;
   $content = trim(file_get_contents($vcard["tmp_name"]));
   $begin = substr($content, 0, 11 );
   $end = substr($content, strlen($content)-9, strlen($content));
   if($begin != "BEGIN:VCARD" || $end != "END:VCARD"){
     $errors["card-type"] = "{$vcard["name"]} is not a .vcf file";
     return $formOK = false;
   } else {
     return $formOK=true;
    }

}

function validate_image($img){
  global $errors;
  $check = getimagesize($img["tmp_name"]);
    //validate that it is an image
  if($check !== false) {
    return $formOk = true;
  } else {
      $errors["img-type"] = "{$img["name"]} is not an image.";
      return $formOK = false;
  }

}

//more generic duplicate record validation
function validate_dup_record($record, $table, $column){
  global $connection;
  global $errors;
  $query = "SELECT COUNT(*) FROM {$table} WHERE {$column}='{$record}'";
  $result = mysqli_query($connection,$query);
  confirm_query_query($result, $query);
  $found = mysqli_fetch_assoc($result);
    if($found["COUNT(*)"]>0) {
        $errors["dup_record"] = "{$table}: {$record} already exists, select another";
        $formOK = false;
      } else {$formOK = true;}
    return $formOK;
}

function validate_dup_user_by_filename($record, $table, $column, $user_id){
  global $connection;
  $query = "SELECT COUNT(*) FROM {$table} WHERE {$column}='{$record}' AND user_id={$user_id}";
  $result = mysqli_query($connection,$query);
  confirm_query_query($result, $query);
  $found = mysqli_fetch_assoc($result);
    if($found["COUNT(*)"]>0) {
        $formOK = false;
      } else {$formOK = true;}
    return $formOK;
}

function validate_dup_filenames($files, $user_id){
  global $connection;
  global $errors;
  $file_exists = "";
  $filenames = "";
  foreach($files as $file => $key){
    $result = validate_dup_user_by_filename($key["name"], $file, "display_name", $user_id);
    if(!$result){
      $file_exists .= "{$file}, {$key["name"]}, ";
    }
  }
  if(empty($file_exists)){
      $formOK = true;
  } else {
    $errors["dup-filname"] = "Files: {$file_exists} already exist(s) associated with your username. Please select a different filename";
    $formOK = false;
  }
  return $formOK;
}








?>
