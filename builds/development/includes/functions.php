<?php

function redirect_to($new_location) {
  header("Location: {$new_location}");
  exit;
}

function mysql_prep($string) {
  global $connection;
  //quotemeta will escape $
  // $escaped_string = quotemeta($string);
  $escaped_string = mysqli_real_escape_string($connection,$string);
  return $escaped_string;
}

function confirm_query($result_set) {
  // Test if there was a query error
  if (!$result_set) {
    die("Database query failed.");
  }
}

function confirm_query_query($result_set, $query) {
  // Test if there was a query error
  if (!$result_set) {
    die("Database query failed. {$query}");
  }
}

function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
	  $output .= "<div class=\"error\">";
	  $output .= "Please fix the following errors:";
	  $output .= "<ul>";
	  foreach ($errors as $key => $error) {
	    $output .= "<li>";
      $output .= htmlentities($error);
      $output .= "</li>";
	  }
	  $output .= "</ul>";
	  $output .= "</div>";
	}
	return $output;
}

function is_item_in_list($item_id, $array){
  $result = has_inclusion_in($current_user, $user_array);
}

function uuidSecure() {

   $pr_bits = null;
   $fp = @fopen('/dev/urandom','rb');
   if ($fp !== false) {
       $pr_bits .= @fread($fp, 16);
       @fclose($fp);
   } else {
       // If /dev/urandom isn't available (eg: in non-unix systems), use mt_rand().
       $pr_bits = "";
       for($cnt=0; $cnt < 16; $cnt++){
           $pr_bits .= chr(mt_rand(0, 255));
       }
   }

   $time_low = bin2hex(substr($pr_bits,0, 4));
   $time_mid = bin2hex(substr($pr_bits,4, 2));
   $time_hi_and_version = bin2hex(substr($pr_bits,6, 2));
   $clock_seq_hi_and_reserved = bin2hex(substr($pr_bits,8, 2));
   $node = bin2hex(substr($pr_bits,10, 6));

   /**
    * Set the four most significant bits (bits 12 through 15) of the
    * time_hi_and_version field to the 4-bit version number from
    * Section 4.1.3.
    * @see http://tools.ietf.org/html/rfc4122#section-4.1.3
    */
   $time_hi_and_version = hexdec($time_hi_and_version);
   $time_hi_and_version = $time_hi_and_version >> 4;
   $time_hi_and_version = $time_hi_and_version | 0x4000;

   /**
    * Set the two most significant bits (bits 6 and 7) of the
    * clock_seq_hi_and_reserved to zero and one, respectively.
    */
   $clock_seq_hi_and_reserved = hexdec($clock_seq_hi_and_reserved);
   $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved >> 2;
   $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved | 0x8000;

   return sprintf('%08s-%04s-%04x-%04x-%012s',
       $time_low, $time_mid, $time_hi_and_version, $clock_seq_hi_and_reserved, $node);
}

//=================user functions=============================
function create_user($user=array()){
  global $connection;
  global $errors;
        $query = "INSERT into user (";
        $query .= "username, firstname, middlename, lastname, hashed_password, user_type_id";
        $query .= ") values (";
        $query .= "'{$user["username"]}', '{$user["firstname"]}', '{$user["middlename"]}', '{$user["lastname"]}', '{$user["hashed_password"]}', {$user["user_type_id"]}";
        $query .= ") ";

        $result = mysqli_query($connection, $query);
        confirm_query_query($result,$query);
        $new_user_id = mysqli_insert_id($connection);

        if($result) {
          $_SESSION["message"] = "User Created";
          return $new_user_id;
        } else {
          $_SESSION["message"] = "User creation failed";
        }
}

function find_all_users($active_only) {
  global $connection;
  $query = "SELECT * ";
  $query .= "from user ";
  if($active_only){
    $query .= "WHERE is_active = true ";
  }  $query .= "ORDER by username ASC";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result) {
    return $result;
  } else {
    $_SESSION["message"] = "query failed";
  }
}

function find_all_user_array($active_only){
  $user_array = array();
  $user_set =find_all_users($active_only);
  while ($user = mysqli_fetch_assoc($user_set)){
    $user_array[] = $website["user_id"];
  }
  return $user_array;
}

function find_all_usernames() {
  global $connection;
  $query = "SELECT username ";
  $query .= "from user ";
  $query .= "ORDER by username ASC";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  return $result;
}

function find_user_by_id($user_id) {
  global $connection;
  $query = "SELECT * ";
  $query .= "from user ";
  $query .= "WHERE user_id = {$user_id} ";
  $query .= " LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  $user_record = mysqli_fetch_assoc($result);
  if($user_record){
    return $user_record;
  } else {return null;}
}

function find_user_by_username($username) {
  global $connection;
  $query = "SELECT * ";
  $query .= "from user ";
  $query .= "WHERE username = '{$username}' ";
  $query .= " LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  $user_record = mysqli_fetch_assoc($result);
  if($user_record){
    return $user_record;
  }else {
    return null;
  }
}

function find_users_by_type($active_only, $user_type_id){
  global $connection;
  $query = "SELECT * ";
  $query .= "from user ";
  $query .= "WHERE user_type_id = {$user_type_id} ";
  if($active_only){
    $query .= "AND is_active = 1 ";
  }
  $query .= "order by username";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result){
    return $result;

    } else {
      return null;
    }
}

function user_array_by_user_type($active_only, $user_type_id){
  $user_array = array();
  $user_set = find_users_by_user_type($active_only, $user_type_id);
  while ($result = mysqli_fetch_assoc($user_set)){
    $user_array[]=$result["user_id"];
  };
  if($user_array){
    return $user_array;
  }else {
    return null;
  }
}

function find_user_type_by_user_type_id($user_type_id) {
  global $connection;
  $query = "SELECT * ";
  $query .= "from user_type ";
  $query .= "WHERE ";
  $query .= "user_type_id = {$user_type_id} ";
  $query .= "LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  $user_user_type = mysqli_fetch_assoc($result);
  if($user_user_type){
    return $user_user_type;
  } else {return null;}
}

function find_user_type_by_user_id($user_id){
  global $connection;
  $query = "Select ut.user_type from user u, user_type ut ";
  $query .= "WHERE ";
  $query .= "u.user_type_id = ut.user_type_id ";
  $query .= "AND ";
  $query .= "u.user_id = {$user_id} ";
  $query .= "LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  $user_type = mysqli_fetch_assoc($result);
  if($result){
    return $user_type["user_type"];} else {return "not found";}
}


//generate unique and random string
function generate_salt($length){
  $unique_random_string = md5(uniqid(mt_rand(),true));
  //valid characters for salt are [0-9a-zA-Z./]
  $base_64_string = base64_encode($unique_random_string);
  // exclude +
  $modified_base_64_string = str_replace('+','.',$base_64_string);
  //truncate string to the correct length
  $salt = substr($modified_base_64_string,0,$length);
  return $salt;
}

function authenticate_user($username, $password){
  $user_record = find_user_by_username($username);
  if($user_record){
    $password_verify = password_verify($password, $user_record["hashed_password"]);
    if($password_verify){
      return $user_record;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function logged_in(){
  return isset($_SESSION["user_id"]);
}

function confirm_login() {
   if(!logged_in()){
    redirect_to("login.php"); }
}


//record status functions and delete functions
function find_active_status($record_id, $table){
  global $connection;
  $query = "SELECT is_active from ";
  $query .= "{$table} ";
  $query .= "WHERE {$table}_id=";
  $query .= "{$record_id}";
  $query .= " LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);;
  $result_set = mysqli_fetch_assoc($result);
  $active = $result_set["is_active"];
  if($active==true){
        return $active;
  } else {
      return false;}
}

function toggle_active($record_id, $table){
  global $connection;
  $active = "";
  $active = find_active_status($record_id, $table);
  $query = "UPDATE {$table} set ";
  $query .= "is_active =";
  if($active){
    $query .= "false ";
  } else {
    $query .= "true ";
  }
  $query .= "WHERE ";
  $query .= "{$table}_id=";
  $query .= "{$record_id}";
  $query .= " LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result && mysqli_affected_rows($connection) >= 0){
    $_SESSION["message"] = "update was successful";
      redirect_to("client.php");
    } else {
    $_SESSION["message"] = "database could not update page record";
      redirect_to("client.php");
    }
}

function delete($record_id, $table) {
    global $connection;
    $query = "DELETE from {$table} WHERE {$table}_id = {$record_id}";
    $result = mysqli_query($connection, $query);
    confirm_query_query($result, $query);
    return $result;
}

function delete_by_foreign_key($record_id, $col_name, $table) {
    global $connection;
    $query = "DELETE from {$table} WHERE {$col_name} = {$record_id}";
    $result = mysqli_query($connection, $query);
    confirm_query_query($result, $query);
    return $result;
}

function delete_user($user_id){
  global $connection;
    $result1 = delete_by_foreign_key($user_id, "user_id","user_url");
    $result2 = delete($user_id, "user");
      if($result2 && mysqli_affected_rows($connection) >= 1){
      $_SESSION["message"] = "delete was successful";
        redirect_to("client.php#user-admin");
      } else {
      $_SESSION["message"] = "database could not delete record";
      redirect_to("client.php#user-admin");
      }
}


//==================bizcard records========================

function generate_1000_numbers(){
  //database column needs to be bigint
global $connection;
$query = "";
for ($i=1;$i<=1000;$i++){
  $num = mt_rand();
  $query .= "INSERT into random_num (num) VALUES ({$num});";
  }
  $result = mysqli_multi_query($connection, $query);
  $confirm = confirm_query_query($result, $query);

  return $confirm;

}

function create_new_filename($dir, $file){
    $continue = true;
    while ($continue) {
        $uuid = uuidSecure();
        $uuid_stripped = str_replace("-","", $uuid);
        $new_filename = $dir.$uuid_stripped.".".pathinfo($file,PATHINFO_EXTENSION);
        if(!file_exists($new_filename)){
          $continue = false;
        }
        return $new_filename;
    }
}

function move_uploaded_files($files, $max_file_size, $bizimg_dir){
    global $errors;
    $file_err = "";
    $kbsize = $max_file_size/1000;
    $mbsize = $kbsize/1000;
    foreach($files as $file => $key){
      if($key["size"] > $max_file_size && strpos($key["type"], "image") !== false){
        //compress image size until it meets criteria starting at quality = 90
        $result = validate_img_size($key, $max_file_size, 90, $bizimg_dir);
        } else {
          $result = move_uploaded_file($key["tmp_name"], $key["new_path"]);
          }
        if(!$result){
          $file_err .= "{$file} - {$key["name"]}, ";
          }
      } //end of for each
      if(!empty($file_err)){
        $errors["move-file"] = "{$file_err} were NOT MOVED";
        }
     else { $_SESSION["message"] .= "files were moved to new directory";
       return true;
     }
  }

function insert_bizcard_file_records($files, $user_id){
  global $connection;
  $file_err = "";
  $id = array();
  foreach($files as $file => $key){
    $query = "INSERT into {$file} (";
    $query .= "display_name, filename, user_id";
    $query .= ") VALUES (";
    $query .= "'{$key["name"]}', '{$key["new_path"]}', {$user_id}); ";
    $result = mysqli_query($connection, $query);
    confirm_query_query($result, $query);
      if($result && mysqli_affected_rows($connection)>=0){
        $ids[$file] = mysqli_insert_id($connection);
      } else { $file_err .= "{$key["new_path"]}, ";}
    }
  if(!empty($file_err)){
    $_SESSION["message"] .= "{$file_err} records were NOT created";
  } else {
    $cnt = count($ids);
    $_SESSION["message"] .= "{$cnt} bizcard db file records have been created. <br>";
    return $ids;
  }
}

function insert_og_tags($og, $user_id){
  global $connection;
  global $errors;
  $og_title = mysql_prep($og["title"]);
  $og_desc = mysql_prep($og["desc"]);
    $query = "INSERT into og_tag (";
    $query .= "og_title, og_desc, user_id";
    $query .= ") VALUES (";
    $query .= "'{$og_title}', '{$og_desc}', {$user_id}); ";
    $result = mysqli_query($connection, $query);
    confirm_query_query($result, $query);
      if($result && mysqli_affected_rows($connection)>0){
        $_SESSION["message"] = "og records created";
        $og_tag_id = mysqli_insert_id($connection);
        return $og_tag_id;
      } else { $errors["og"] = "og records could NOT be created";
      return null;
    }
  }

function create_bizcard_file_assoc($ids, $og_tag_id, $user_id){
  global $connection;
  global $errors;
  $query = "INSERT into user_bizcard (";
  $query .= "user_id, bizimg_id, vcard_id, og_tag_id";
  $query .= ") VALUES (";
  $query .= "{$user_id}, {$ids["bizimg"]}, {$ids["vcard"]}, {$og_tag_id}) ";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result && mysqli_affected_rows($connection)>=0){
    $user_bizcard_id = mysqli_insert_id($connection);
    $_SESSION["message"] .= "User bizcard file association successful.<br>";
    return $user_bizcard_id;
  } else { $_SESSION["message"] = "file assoc not succesful";}
}

function create_file_records($files, $user_id, $og, $max_file_size, $bizimg_dir){
  global $connection;
  global $errors;
  $recordOK = true;
  $ids = insert_bizcard_file_records($files, $user_id);
  if(!isset($ids)){
    $recordOK = false;
     }
  $og_tag_id = insert_og_tags($og, $user_id);
  if(!$og_tag_id){
    $recordOK = false;
  }
  $user_bizcard_id = create_bizcard_file_assoc($ids, $og_tag_id, $user_id);
  if(!$user_bizcard_id){
    $recordOK = false;
  }
  $result = move_uploaded_files($files, $max_file_size, $bizimg_dir);
  if(!$result){
    $recordOK = false;
  }
  if($recordOK){
    $_SESSION["message"] .= "File creation successs!<br>";
    return $user_bizcard_id;
  } else {
  $_SESSION["message"] .= "File creation could NOT be completed";
  return null;
  }
}

function find_another_field_by_field($record, $table, $field, $field_to_return){
  global $connection;
  global $errors;
  $query = "SELECT * from {$table} ";
  $query .= "WHERE ";
  $query .= "{$field}='{$record}' ";
  $query .= "LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result){
  $record = mysqli_fetch_assoc($result);
  return $record[$field_to_return];
  }  else {$errors["record"] = "no database record found";}
}

function find_record_by_field($record, $table, $field){
  global $connection;
  global $errors;
  $query = "SELECT * from {$table} ";
  $query .= "WHERE ";
  $query .= "{$field}='{$record}' ";
  $query .= "LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result){
  $record = mysqli_fetch_assoc($result);
  return $record;
  }  else {$errors["record"] = "no database record found";}
}

function create_bizcard_record($user_bizcard_id, $drdcard, $drdpin){
  global $connection;
  global $errors;
  $hashed_pin = password_hash($drdpin,PASSWORD_DEFAULT);
  $query = "INSERT into bizcard (";
  $query .= "user_bizcard_id, drdcard, hashed_pin ";
  $query .= ") VALUES (";
  $query .= "{$user_bizcard_id}, '{$drdcard}', '{$hashed_pin}'); ";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result && mysqli_affected_rows($connection)>=0){
    $bizcard_id = mysqli_insert_id($connection);
    $result = find_another_field_by_field($bizcard_id,"bizcard","bizcard_id","drd_redirect");
    $drd_redirect = $result;
    $_SESSION["message"] .= "bizcard record created <br>";
    return $drd_redirect;
  } else { $_SESSION["message"] = "bizcard could not be created";}

}


function get_bizcard_items($user_bizcard_id){
  global $connection;
  global $errors;
  $query = "SELECT b.filename as bizimg, ";
  $query .= "v.filename as vcard, ";
  $query .= "ub.user_id, ";
  $query .= "ot.og_title, ";
  $query .= "ot.og_desc ";
  $query .= "FROM ";
  $query .= "user_bizcard ub, bizimg b, vcard v, og_tag ot ";
  $query .= "WHERE ";
  $query .= "ub.bizimg_id = b.bizimg_id AND ub.vcard_id = v.vcard_id AND ub.og_tag_id = ot.og_tag_id AND ";
  $query .= "user_bizcard_id = {$user_bizcard_id} ";
  $query .= "LIMIT 1";
  $result = mysqli_query($connection, $query);
  confirm_query_query($result, $query);
  if($result){
    $bizcard_content = mysqli_fetch_assoc($result);
    $_SESSION["message"] = "bizcard content was returned<br>";
    return $bizcard_content;
  } else {$errors["bizcard-content"] = "bizcard content was NOT retrieved";
  return null;}
}

function build_bizcard_output($drdcard,$vcard,$bizimg,$og_title,$og_desc){
  $og_title = htmlentities($og_title);
  $og_desc = htmlentities($og_desc);
  $drdcard = htmlentities($drdcard);
  $vcard = htmlentities($vcard);
  $bizimg = htmlentities($bizimg);
  $output = "<?php include(\"layouts/head2.php\"); ?>";
  $output .= "<title>{$drdcard}</title>";
  $output .= "<!-— facebook open graph tags -->";
  $output .= "<meta property=\"og:type\" content=\"website\" />";
  $output .= "<meta property=\"og:url\" content=\"https://drd.cards/{$drdcard}\" />";
  $output .= "<meta property=\"og:title\" content=\"{$og_title}\" />";
  $output .= "<meta property=\"og:description\" content=\"{$og_desc}\" />";
  $output .= "<meta property=\"og:image\" content=\"https://drd.cards/{$bizimg}\" />";
  $output .= "<?php include(\"layouts/header2.php\"); ?>";
  $output .= "<div id='bizcard'><img class='bizimg' src='{$bizimg}' alt=\"{$drdcard}'s bizimg\">";
  $output .= "<a id='bizimg-anchor' href='{$vcard}' download> download contact </a></div>";
  $output .=  "<?php include(\"layouts/footer.php\"); ?>";
  return $output;
  }

  function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }

    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}
}


function compress_image($source_url, $destination_url, $quality) {
  $info = getimagesize($source_url);

      if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source_url);

      elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source_url);

    elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source_url);
      imagejpeg($image, $destination_url, $quality);

  return $destination_url;
}

function validate_img_size($bizimg, $max_file_size, $quality, $dc_root){
  $new_filename = $bizimg["new_path"];
  global $errors;
  if(!file_exists($dc_root."temp/")){
        $temp_dir = mkdir($dc_root."temp/");
      } else {$temp_dir = $dc_root."temp/";}
      $bizimg_temp = $temp_dir."bizimg_temp.jpg";
      $result = move_uploaded_file($bizimg["tmp_name"], $bizimg_temp);
      if(!$result){ $errors["file-move"] = "could not move file";} else {
          $i = 1;
          $continue = true;
          $file = $bizimg_temp;
          while($continue == true){
          $new_img = compress_image($file, $new_filename, $quality);
          if(filesize($new_img) < $max_file_size){
            $continue = false;
            unlink($bizimg_temp);
            rmdir($temp_dir);
            return $new_img;
          }
          unlink($new_filename);
          $quality = $quality - 10;
          $i++;
        } //end while loop

    }
}

function retrieve_og_tags($url){
  $graph = OpenGraph::fetch($url);
  var_dump($graph->keys());
  var_dump($graph->schema);

  foreach ($graph as $key => $value) {
  	echo "$key => $value<br>";
  }
}




?>
