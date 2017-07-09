<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation.php"); ?>
<?php confirm_login() ?>

<!-- ====================page content ===================================-->
<?php include("../layouts/header.php") ?>
<?php

$user_id = $_SESSION["user_id"];
$username = mysql_prep($_SESSION["username"]);
$user_record = find_user_by_id($user_id);
$role_id = $user_record["role_id"];
$role = find_role_by_role_id($role_id);
$role_name = $role["role_name"];
if(isset($_SESSION["message"])){
  $message = $_SESSION["message"];
} else { $message = null;}
$user_record = find_user_by_id($user_id);
$user_role= find_role_by_role_id($role_id);
$role = ucwords($user_role["role_name"]);

 ?>


  <body>
    <section class="background-pic"></section>
    <main class='main yel-white-background' id='manage-client'>
      <section class="section client-section">
        <div class="logout">
          <a href="logout.php">+Logout</a>
        </div>
        <div class="title">
          <a class='a-with-img' href='../../index.html'><img class='logo' src='../../images/logos/DRD_circle.svg'></a>
          <h2><?php echo $role; ?> Page</h2>
          <h3>Welcome to Dame Ranch Design's <?php echo $role; ?> Page, <?php echo ucwords($user_record["first_name"]); ?> </h3>
        </div>
        <!-- errors and message divs -->
         <?php if($role_id== 1){ ?>
         <section class="" id="user-admin">
          <div>
            <?php If(!empty($message)) { ?>
            <?php   if (!empty($message)) {
            echo "<div class ='error-div white-background'>" . htmlentities($message) . "</div>";
            $message = null; $_SESSION["message"] = null;
              }; ?>
          </div>
          <?php } ?>
          </div>
          <h3>Manage Users</h3>
          <?php
        $user_set = find_all_users(0);
        if(!empty($user_set)){
          $output = "<div class='white-background client-output'><table>";
          $output .= "<thead><tr>
                    <th>Username</th>
                    <th>Action</th>
                  </tr></thead><tbody>";
          while ($users = mysqli_fetch_assoc($user_set)){
            $active = ($users["is_active"] ? "Inactivate":"Activate");

            $output .= "<tr><td class = 'first-cell'>";
            $output .= $users["username"];
            $output .= "</td><td>";
            $output .= "<a href='edit_client.php?user_id=";
            $output .= $users["user_id"];
            $output .= "'>Edit</a>&nbsp;&nbsp;<a href='delete.php?action=delete_user&user_id=";
            $output .= $users["user_id"];
            $output .= "'>Delete</a>&nbsp;&nbsp;<a href='delete.php?action=toggle_active&user_id=";
            $output .= $users["user_id"];
            $output .="'>";
            $output .= $active;
            $output .= "</a></td></tr>";
            }
            $output .= "</tbody></table>";
            echo $output;
        } else {
          echo "<h3>There are no users</h3>";
        } ?>

            <h3><a href="create_user.php">+Add New User</a></h3>
          </div>

        </section>

        <section class = "client-section" id="website-admin">
          <h3>Manage Websites</h3>
          <?php
        $url_set = find_all_websites(0);
        if(!empty($url_set)){
          $output = "<div class='white-background client-output'><table>";
          $output .= "<thead><tr>
                    <th>Website</th>
                    <th>Action</th>
                  </tr></thead><tbody>";
          while ($url = mysqli_fetch_assoc($url_set)){
            $active = ($url["is_active"] ? "Inactivate":"Activate");

            $output .= "<tr><td class = 'first-cell'><a target='_blank' href='";
            $output .= htmlentities($url["url"]);
            $output .= "' >";
            $output .= htmlentities($url["url_name"]);
            $output .= "</a></td><td>";
            $output .= "<a href='edit_url.php?url_id=";
            $output .= $url["url_id"];
            $output .= "'>Edit</a>&nbsp;&nbsp;<a href='delete.php?action=delete_url&url_id=";
            $output .= $url["url_id"];
            $output .= "'>Delete</a>&nbsp;&nbsp;<a href='delete.php?action=toggle_active&url_id=";
            $output .= $url["url_id"];
            $output .="'>";
            $output .= $active;
            $output .= "</a></td></tr>";
            }
            $output .= "</tbody></table>";
            echo $output;
        } else {
          echo "<h3>There are no urls</h3>";
        } ?>

            <h3><a href="create_url.php">+Add New Website</a></h3>
          </div>
        </section>
        <?php } ?>
        <?php if($role_id == 2){ ?>
        <section class="client-section" id="view-website">
          <div>
            <?php If(!empty($message)) { ?>
            <?php   if (!empty($message)) {
            echo "<div class ='error-div white-background'>" . htmlentities($message) . "</div>";
            $message = null; $_SESSION["message"] = null;
              }; ?>
          </div>
          <?php } ?>
          </div>
           <h3>View Your Websites</h3>
           <?php
             $url_set = find_websites_by_user($user_id);
             if(!empty($url_set)){
               $output = "<ul class='white-background client-output'>";

               while ($url = mysqli_fetch_assoc($url_set)){

                 $output .= "<li><a target='_blank' href='";
                 $output .= htmlentities($url["url"]);
                 $output .= "'>";
                 $output .= htmlentities($url["url_name"]);
                 $output .= "</a></li>";
                 }
                 $output .= "</ul>";
                 echo $output;
             } else {
               echo "<h3>There are no users</h3>";
             } ?>
             <h3><a href='update_client_profile.php?user_id=<?php echo $user_id ?>'>Update your profile</a></h3>
       </section>
       <?php } ?>
       <pre>

       </pre>

        <?php include("../layouts/footer.php") ?>
