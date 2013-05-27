<?php
    $info = $this->info;
?>
<div>
    <a href="" class="addFixture">Add Fixture</a>
    <form action="" method="POST">
        <input type="text" name="fixtures[search]"/>
        <input type="submit" name="submit" value="Search"/>
    </form>
    <div id="fixtureSearch">
        <?php foreach($info as $i){ ?>
        <div><?php echo $i['name']; ?></div>
        <?php } ?>
    </div>
</div>
<script>
    function overlay(layout){
                $('#mainOverlay').stop();
                $('#overlayFormHolder').stop();

                var link = layout;
                $.ajax({
                        url: link+'&ajax=1',
                        type: 'POST',
                        success: function(html){
                                $('#overlayForm').html(html);

                                $('#mainOverlay').css('opacity','0').css('display','block');
                                $('#overlayFormHolder').css('opacity','0').css('display','block');

                                var top = $('#overlayForm').height()/2;
                                var left = $('#overlayForm').width()/2;
                                $('#overlayForm').css('top','-'+top+'px').css('left','-'+left+'px');

                                $('#mainOverlay').animate({'opacity':1},500);
                                $('#overlayFormHolder').animate({'opacity':1},500);

                                $('#mainOverlay').click(function(){
                                        $('#mainOverlay').stop();
                                        $('#overlayFormHolder').stop();
                                        $('#mainOverlay').animate({'opacity':0},500,function(){ $(this).css('display','none'); });
                                        $('#overlayFormHolder').animate({'opacity':0},500,function(){ $(this).css('display','none'); $('#overlayForm').html(''); });
                                })
                        }
                })
                return false;
    }
    $('.addFixture').click(function(){
        overlay('?page=fixtures/createForm&ajax=1');
        return false;
    })
</script>
