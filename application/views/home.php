<!--<!DOCTYPE html>
<html lang="en">
<title>home page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href=" asset\css\homepage.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
<body>


<div class="w3-top">
  <div class="w3-bar w3-red w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>

  </div>

  <div class="w3-container w3-red w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo">START PAGE</h1>
  <form action="http://localhost/codeigniter/index.php/home/add_item">
    <button  class="w3-button w3-black w3-padding-large w3-large w3-margin-top">Add Items</button>
      </form>
 
  </div>
-->


<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Products</h1>
        </div>
    <div class="row">
        <?php if (count($items) == 0):?>
            <div class="col-6">
                <div class="alert alert-danger">Product not found</div>
            </div>
        <?php endif; ?>
            <?php foreach($items as $item): ?>
            <div class="col-4">
                <div class="card" >
                    <img src="<?=base_url('uploads/'.$item->image)?>" class="card-img-top" alt="<?=$item->title?>">
                    <div class="card-body">
                      <h5 class="card-title"><?=$item->title?></h5>
                      <p class="card-text"><?=$item->price?>Rs/-</p>
                      <a href="<?=site_url('add/'. $item->id)?>" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            </div>    
        <?php endforeach;?>
    </div>
    <div class="row">
        <div class="col-12 m-auto">
            <?=$pagination?>
        </div>  
    </div>
</div>
