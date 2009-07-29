<?php if (!empty($login_inactive)): ?>
    <p>Sorry, that login has been disabled.</p>
<?php endif ?>

<?php if (!empty($no_verified_email)): ?>
    <p>
    The account you are attempting to login with has not been activated. In order
    to use BYOB, you must first activate your account by following the instructions
    that were sent to the email address associated with that account. If you did
    not receive this email, please ensure any anti-spam methods will accept mail
    from admin@byob.mozilla.com and use the 
    "Re-send Account Activation Information" button below. If
    you still do not receive the activation information, please contact us.
    </p>
    <form action="<?=url::base().'reverifyemail/'.urlencode($_POST['login_name'])?>" method="POST">
        <input type="submit" value="Re-send Account Activation Information" />
    </form>
<?php endif ?>

<?= 
form::build('login', array('class'=>'login'), array(
    form::field('hidden', 'jump', ''),
    form::fieldset('login details', array('class'=>'login'), array(
        form::field('input',    'login_name',       'Login name'),
        form::field('password', 'password',         'Password'),
        form::field('submit',   'login',  null, array('value'=>'login')),
        html::anchor('/forgotpassword', 'Forgot password?'),
    ))
)) 
?>
