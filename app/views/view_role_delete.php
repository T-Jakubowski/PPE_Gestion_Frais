<?php
namespace app\views;

?>
<html>
<?php require "Head.php" ;?>

  <body>
    <?php $ActivePageName="role"; require "view_NavBarre.php"; ?>
    <br>
<?php
if (isset($resultMessage)){?>
    <div class="alert alert-success mt-5" role="alert">
      <h2><img class="fit-picture" src="/img/check_black_24dp.svg" alt="success"><?php echo $resultMessage;?></h2>
    </div>
<?php }
elseif(isset($valueError)){
    ?>
    
    <h2><?php echo $valueError;?>
      
    </h2><br>
<?php
}else{
  echo "Desoler un probleme est survenue veuillez reeseyer plus tard";
}
?>
