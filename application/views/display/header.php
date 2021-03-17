<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
        <title>Docs</title>
        <link rel='stylesheet' href="<?=base_url()?>assets/css/bootstrap.min.css"  >
        <link rel='stylesheet' href="<?=base_url()?>assets/css/style.css"  >
        <link rel="stylesheet" href="<?=base_url()?>assets/css/open-iconic-bootstrap.css" >
        <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap1.min.css">
    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?=site_url()?>">OL Shopping</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?=site_url()?>">Home <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url()?>page/1-about_us">About us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url()?>page/3-contact_us">Contact us</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php foreach($categories as $category):?>
          <a class="dropdown-item" href="<?=base_url('category/'.$category->id)?>"><?=$category->title?></a>
        <?php endforeach;?>
        </div>
      </li>
     
    </ul>


    <?php if(isset($user['logged']) && $user['logged']):?>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=$user['first_name']?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="<?=base_url('cart')?>">Shopping Cart</a>
          <a class="dropdown-item" href="<?=base_url('orders')?>">Orders</a>

        <?php if($user['level'] >= 1):?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?=base_url('manager/orders')?>">Orders</a>
          <a class="dropdown-item" href="<?=base_url('manager/items')?>">Products</a>
          <a class="dropdown-item" href="<?=base_url('manager/categories')?>">Categories</a>
          <a class="dropdown-item" href="<?=base_url('manager/pages')?>">Pages</a>
        <?php endif;?>

        <?php if($user['level'] == 2):?>
          <a class="dropdown-item" href="<?=base_url('manager/users')?>">Users</a>
        <?php endif;?>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?=base_url('home/logout')?>">Logout</a>
        </div>
      </div>
    <?php else:?>
      <a class="nav-link" href="<?=base_url('home/login')?>">Enter</a>

    <?php endif;?>

    

    <form class="form-inline my-2 my-lg-0" actiion="" method="get">
      <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<?php if(isset($alert) && is_array($alert)):?>
  <div class="container">
    <div class="row">
      <div class="col-6">
        <div class="alert alert-<?=$alert['type']?>"><?=$alert['message']?></div>
      </div>
    </div>
  </div>
<?php endif;?>
  