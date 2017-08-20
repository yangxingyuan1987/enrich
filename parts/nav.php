<?php
function get_nav($conponents)
{?>
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded sticky-top">
    <a class="navbar-brand" href=" http://<?= $_SERVER["SERVER_NAME"]?>">EPC</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
<?php
    foreach ($conponents as $name => $file)
    {
        echo '<li class="nav-item">';
        echo '<a class="nav-link" href="'.$file.'">'.$name.'</a>';
        echo "<li>";
    }
?>
    </ul>
    </div>
    </nav>
<?php 
} 
?>