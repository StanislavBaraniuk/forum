<?php

    $likes = $this->getCollectionLikes();

    $creates =  $this->getCollectionOwn();

?>

<div class="indexContent">
    <div class="profile-block">
        <div class="info row">
            <div class="col-xl  col-12 block">
                <div class="title">
                    ACCOUNT
                </div>
                <div class="item">
                    <span>Name:</span><a><?php echo Aquilon::_POST('name') ?></a>
                </div>
                <div class="item">
                    <span>Email:</span><a><?php echo Aquilon::_POST('login') ?></a>
                </div>
                <div class="item">
                    <span>Account was created:</span><a><?php echo Aquilon::_POST('create_at') ?></a>
                </div>
                <a onclick="closeAnotherSessions()" href="">Close another sessions</a>
            </div>
            <div class="col-xl  col-12 block">
                <form action="http://frm.zzz.com.ua/user/update/info" method="post">
                    <div class="title">
                        CHANGE USER INFO
                    </div>
                    <div class="item">
                        <input placeholder="NAME" type="text" value="<?php echo Aquilon::_POST('name') ?>" name="name">
                    </div>
                    <div class="item">
                        <input placeholder="EMAIL" type="email" value="<?php echo Aquilon::_POST('login') ?>" name="email">
                    </div>
                    <button type="submit">CHANGE</button>
                </form>
            </div>
            <div class="col-xl col-12 block">
                <form action="http://frm.zzz.com.ua/user/update/password" method="post">
                    <div class="title">
                        CHANGE PASSWORD
                        <small class="color-red"><?php echo ErrorHandler::getError('AuthorizationFail')['value'] ?></small>
                    </div>
                    <div class="item">
                        <input  placeholder="old password" type="password" name="old_password" class="<?php echo ErrorHandler::getError('AuthorizationFail') === null ? '' : ' border-red ' ?>">
                    </div>
                    <div class="item">
                        <input  placeholder="new password" type="password" name="new_password" class="<?php echo ErrorHandler::getError('AuthorizationFail') === null ? '' : ' border-red ' ?>">
                    </div>
                    <button type="submit">CHANGE</button>
                </form>
            </div>
        </div>
        <div class="own row">
            <div class="col-lg-6 ol-md-12 block">
                <i class="far fa-heart"></i>
                <?php foreach ($likes as $like) : ?>
                    <div class="discuss row">
                        <div class="col-md col-sm-12 item"><?php echo Aquilon::getByKey($like, 'title') ?></div>
                        <div class="col-md col-sm-12 item"><?php echo Aquilon::getByKey($like, 'create_at') ?></div>
                        <div class="col-md col-sm-12 item" onclick="window.location.href='/discussion/open/<?php echo  Aquilon::getByKey($like, 'id') ?>'"><i class="fas fa-sign-in-alt"></i></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-6 col-md-12 block">
                <i class="far fa-edit"></i>
                <?php foreach ($creates as $create) : ?>
                    <div class="discuss row">
                        <div class="col-md col-sm-12 item"><?php echo $create['title'] ?></div>
                        <div class="col-md col-sm-12 item"><?php echo $create['create_at'] ?></div>
                        <div class="col-md col-sm-12 item"><i class="fas fa-sign-in-alt" onclick="window.location.href='/discussion/open/<?php echo $create['id'] ?>'"></i><i class="fas fa-trash-alt" onclick="deleteDiscussion('<?php echo $create['id'] ?>')"></i></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div></div>
    </div>
</div>

<script>
    let reply_id = 0;
    let reply_user_id = 0;

    const closeAnotherSessionsRequest = () =>
        axios.get(
            'http://frm.zzz.com.ua/user/session/close'
        ).then(function (response) {
            return response;
        }).catch(function (error) {
            return error.response;
        });

    const deleteDiscussionRequest = (id) =>
        axios.get(
            'http://frm.zzz.com.ua/discussion/delete/' + id
        ).then(function (response) {
            return response;
        }).catch(function (error) {
            return error.response;
        });

    const closeAnotherSessions = async () => {
        let resp = await closeAnotherSessionsRequest();
    };

    const deleteDiscussion = async (id) => {
        let resp = await deleteDiscussionRequest(id);

        window.location.reload();
    }

</script>