<?php
if ( !empty( $error ) ) {
    ?><div class="error">Invalid username/password combination.</div><?php
}
?>
<form method="post" action="session/create" class="login">
    <div>
        <label>Username</label>
        <input type="text" name="username" />
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" />
    </div>
    <div>
        <input type="submit" value="Log in" />
    </div>
</form>
<script type="text/javascript" src="behavior.js"></script>
