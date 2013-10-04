<?php
require_once("/inc/config.php");
require_once( KEYS_PATH );
session_start();

//set the page title
if( $pageTitle == "Index" ) 
{
	$pageTitle = "Home";
}


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//%     			                    FUNCTIONS
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
function make_navbar()
{ 
  // TODO: finish this
?>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="brand" href="#">Meal Planner</a>  
      <ul class="nav pull-right">  
      <?php if ($_SESSION['user_id'] == NOT_LOGGED_IN){ ?>
        <li><a href="<?php echo REGISTER_PATH;?>">Register</a></li>  
        <?php make_sign_in_dropdown(); ?>
      <?php } else { ?>
        <div class="btn-group">
          <button class="btn"><?php echo $_SESSION['username'];?></button>
          <button class="btn dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="<?php echo SIGN_OUT_PATH;?>">Sign out</a></li>  
          </ul>
        </div>
      <?php } ?>
      </ul>
    </div>
  </div>
</div>
<?php } 


function make_sign_in_dropdown()
{?>
<!-- TODO: make this into a dropdown that lets the user log in -->
<li><a href="#">Sign in</a></li>  

<?php }


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//%     			                     MAIN CODE
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
?>
<html>
<head>
  <title>
    Meal Planner - "<?php echo $pageTitle; ?>"
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" type="text/css" href="<?php echo STYLE_PATH; ?>">
  <link rel="stylesheet" href="<?php echo JQUERY_UI_STYLE_PATH; ?>">
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script src="<?php echo JQUERY_UI_PATH; ?>"></script>
  <script src="/bootstrap/js/bootstrap.js"></script>
</head>
<body>

<?php make_navbar(); ?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">
      <ul>
        <li>
          <a href="<?php echo BASE_URL ?>new_recipe.php">New Recipe</a>
        </li>
        <li>
          <a href="<?php echo BASE_URL ?>new_food.php">New Food</a>
        </li>
        <li>
          <a href="<?php echo BASE_URL ?>view_foods.php">My Foods</a>
        </li>
        <li>
          <a href="<?php echo BASE_URL ?>view_recipes.php">My Recipes</a>
        </li>
      </ul>
    </div>
    <div class="span10">
	  <h2><?php echo $pageTitle ?></h2>
