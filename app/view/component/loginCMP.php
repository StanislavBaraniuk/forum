<div class="indexContent">
    <div class="login-block">
        <form action="" method="post">
            <h3 style="width: 100%; text-align: center"><?php echo Aquilon::_GET('title') ?></h3>
            <?php echo '<small class="color-red">' . ErrorHandler::getError('AuthorizationFail')['value'] . '</small>'; ?>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input
                        value="<?php echo Aquilon::_POST('login') ?>"
                        class="form-control <?php echo ErrorHandler::getError('AuthorizationFail') === null ? '' : ' border-red' ?>"
                        type="email"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Enter email"
                        required="required"
                        name="login">
                <?php echo '<small class="color-red">' . ErrorHandler::getError('ValidateEmailFail')['value'] . '</small>'; ?>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input
                        value="<?php echo Aquilon::_POST('password') ?>"
                        type="password"
                        class="form-control <?php echo ErrorHandler::getError('AuthorizationFail') === null ? '' : ' border-red' ?>"
                        id="exampleInputPassword1"
                        placeholder="Password"
                        required="required"
                        name="password">
                <?php echo '<small class="color-red">' . ErrorHandler::getError('ValidatePasswordFail')['value'] . '</small>'; ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <small style="float: right; margin-top: 10px"><a href="<?php echo Aquilon::_GET('signLink') ?>"><?php echo Aquilon::_GET('signLabel') ?></a></small>
        </form>
    </div>
</div>
