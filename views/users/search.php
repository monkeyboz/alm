<?php
    $info = $this->info;
?>
<?php foreach($info as $i){ ?>
<a href="" id="<?php echo $i['name']; ?>"><?php echo $i['name']; ?></a>
<script>addMarker('uploads/icon/<?php echo $i['name']; ?>.png', 'Type: <?php echo $i['description']; ?><br/>Watts: <?php echo $i['watts']; ?><br/>');</script>
<?php } ?>

