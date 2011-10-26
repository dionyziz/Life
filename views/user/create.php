<?php
if ( !empty( $error ) ) {
    if( $error == 'nomatch' ) {
        ?><div class="error">Passwords do not match.</div><?php
    }
    else if ( $error == 'noregister' ) {
        ?><div class="error">Username already exist. Please try another username.</div><?php
    }
}
?>
<form method="post" action="user/create" class="register">
    <div>
        <label>Username</label>
        <input type="text" name="name" />
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" />
    </div>
    <div>
        <label>Password again</label>
        <input type="password" name="password2" />
    </div>
    <div>
        <input type="submit" value="Register" />
    </div>
</form>
<script type="text/javascript" src="behavior.js"></script>
