<?php if(strlen($bup_error_str)): ?><div id="message" class="updated"><p><?php echo $bup_error_str; ?></p></div><?php endif; ?>
<form action="" method="post">
 <p>To login, please enter your 23press username and password:</p>
 <table width="100%">
  <tr>
   <td width="120">E-mail address:</td>
   <td><input type="text" size="30" name="email" value="<?php echo htmlentities(@$_POST['email']); ?>" /></td>
  </tr>
  <tr>
   <td>Password:</td>
   <td><input type="password" size="30" name="password" /></td>
  </tr>
 </table>
 <input type="hidden" name="bp-action" value="login" />
 <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('login'); ?>" />
 <p><input type="submit" value="Login" class="button-primary" /></p>
 <p><a href="https://ssl.23press.com/login/forgot" target="_blank">Forgot your password?</a></p>
</form>
