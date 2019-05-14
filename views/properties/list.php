<link rel="stylesheet" type="text/css" href="css/tableDisplay.css">
<?php
	$info = $this->info;
?>
    <form action="?page=properties/search" method="POST">
        <span style="color: #fff; font-size: 20px;">Sitemaps</span> <input type="text" value="search" name="search[search]" onclick="$(this).val('');"/>
        <div class="right">
            <select name="search[notes]">
                <option value="active_requests">Active Requests</option>
                <option value="inactive_requests">Inactive Requests</option>
                <option value="no_requests">No Requests</option>
            </select>
            <select name="search[value]">
                <option value="username" <?php if(isset($_POST['search']['value']) && $_POST['search']['value'] == 'first_name'){ ?>selected<?php } ?>>Customer</option>
                <option value="first_name" <?php if(isset($_POST['search']['value']) && $_POST['search']['value'] == 'contact'){ ?>selected<?php } ?>>Contact</option>
                <option value="name" <?php if(isset($_POST['search']['value']) && $_POST['search']['value'] == 'name'){ ?>selected<?php } ?>>Site Name</option>
                <option value="phone" <?php if(isset($_POST['search']['value']) && $_POST['search']['value'] == 'phone'){ ?>selected<?php } ?>>Phone</option>
                <option value="service_interval" <?php if(isset($_POST['search']['value']) && $_POST['search']['value'] == 'service_interval'){ ?>selected<?php } ?>>Service Interval</option>
            </select>
            <input type="submit" value="Search" name="Submit" />
        </div>
    </form>
    <div class="table">
            <div class="header">
                    <div>Site Name</div>
                    <div>Contact</div>
                    <div>Phone</div>
                    <div>Status</div>
                    <div></div>
            </div>
    <?php
    foreach($info as $k=>$i){
            $fixture = $this->query('SELECT * FROM maintenance AS m JOIN fixtures AS f ON m.type_id=f.fixture_id JOIN properties AS p ON f.property_id=p.property_id WHERE p.property_id='.$i['property_id'].' AND m.status != "closed" ORDER BY m.date DESC');
            $contact = $this->query('SELECT * FROM users WHERE user_id='.$i['user_id']);
            $even = ($k%2)?'even':'odd';
            $status = (sizeof($fixture) > 0 )?"<span class='error'>Maintenance Requested</span>":"current";
    ?>
            <div class="<?php echo $even; ?>">
                    <div><a href="?page=properties/propertyDisplay/<?php echo $i['property_id']; ?>"><?php echo $i['name']; ?></a></div>
                    <div><a href="?page=users/view/<?php echo $contact[0]['user_id']; ?>"><?php echo $contact[0]['first_name']; ?></a></div>
                    <div><?php echo $contact[0]['phone']; ?></div>
                    <div><a href="?page=properties/listFixtures/<?php echo $i['property_id']; ?>"><?php echo $status; ?></a></div>
                    <?php $this->editOptions('property',$i['property_id']); ?>
            </div>
    <?php
    }
    ?>
    </div>
    <div class="bottomNav">
            <a href="?page=properties/createForm">New</a>
    </div>