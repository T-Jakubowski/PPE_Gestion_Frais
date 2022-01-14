<?php
namespace app\views;

?>
<html>
<?php require "Head.php" ;?>

  <body>
    <?php $ActivePageName="role"; require "view_NavBarre.php"; ?>
    <br>
<?php
if (isset($resultMessage)) {
  ?>
    <div class="alert alert-success mt-5" role="alert">
      <h2><img class="fit-picture" src="/img/check_black_24dp.svg" alt="success"><?php echo $resultMessage;?></h2>
    </div>
    <?php
  }
elseif(isset($valueError)){
    ?>
    
    <h2>vous avez entré une valeur non valide :</h2><br><h3>
    <?php foreach($valueError as $key=>$value){ 
      ?>
      La valeur pour "<?php echo $value ?>" n'est pas valide<br>
      <?php
    }
    ?></h3><?php
}else{
  echo "Desoler un probleme est survenue veuillez reeseyer plus tard";
}
?>

    <script>

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
    </body>
</html>