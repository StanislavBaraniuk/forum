<div class="discussContent" id="discussContent">
    <div class="body row">
        <div class="col-12 header row">
             <?php
                 $item = $this->getDiscussion();
                 $messages = $this->getMessages();
             ?>

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-xs-12 photo-block">
                <div class="photo" style="background-image: url('<?php echo Aquilon::getByKey($item, 'image') ?>')">
                    <?php echo empty(Aquilon::getByKey($item, 'image')) ? '<i class="fas fa-cat"></i>' : '' ?>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10 col-md-9 col-sm-9 col-xs-12 description">
                <div class="title"><?php echo Aquilon::getByKey($item, 'title') ?></div>
                <div class="author"><?php echo Aquilon::getByKey($item, 'author') ?></div>
                <div class="row">
                    <div class="data col-6"><i class="far fa-clock"></i><span><?php echo StringFilter::filterDate(Aquilon::getByKey($item, 'create_at')); ?></span></div>
                    <div class="data col-6">
                        <span class="tags-block">
                            <?php

                                foreach (Aquilon::getByKey($item, 'tags') as $value) {
                                    echo '<span><i class="fas fa-hashtag">'.Aquilon::getByKey($value, 'tag').'</i></span>';
                                }

                                ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-6 info">
                <div class="users-count counts"><i class="fas fa-users"></i><span><?php echo Aquilon::getByKey($item, "users_count") ?></span></div>
                <div class="views-count counts"><i class="fas fa-eye"></i><span><?php echo Aquilon::getByKey($item, "views") ?></span></div>
                <div class="comments-count counts"><i class="fas fa-comments"></i><span><?php echo Aquilon::getByKey($item, "messages_count") ?></span></div>
            </div>
            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-6 like">
                <div class="block">
                    <div id="likes-count"><?php echo Aquilon::getByKey($item, "likes") ?></div>
                    <i class="far fa-heart <?php echo Aquilon::getByKey($item, "is_like") ? "like-disable" : "like-active" ?>" id="like-not-use" onclick="<?php echo Aquilon::_SESSION('id') ? 'like(this)' : '' ?>"></i>
                    <i class="fas fa-heart  <?php echo !Aquilon::getByKey($item, "is_like") ? "like-disable" : "like-active use" ?>" id="like-use" onclick="<?php echo Aquilon::_SESSION('id') ? 'dislike(this)' : '' ?>"></i>
                </div>
            </div>
        </div>
        <div class="messages container-fluid">
            <div class="row">
                <?php if (count($messages) == 0) : ?>
                    <div style="width: 50%; height: 100px; margin-left: 25%; margin-top: 20px; font-size: 20px; color: #b5b5b5; line-height: 100px; text-align: center; border-top: 1px solid #b5b5b5">Be first here!</div>
                <?php endif; ?>
                <?php foreach ($messages as $message) : ?>
                    <div class="message col-12 row" id="message-<?php echo Aquilon::getByKey($message, 'id') . '_' . Aquilon::getByKey($message, 'user_id') ?>" style="
                    <?php

                        if (Aquilon::_SESSION('id') === Aquilon::getByKey($message, 'reply_user_id')) {
                            echo 'background-color: #00c2ff6b;';
                        }
                        if (Aquilon::_SESSION('id') === Aquilon::getByKey($message, 'user_id')) {
                            echo "background-color: #a6ff006b;";
                        }
                    ?>
                            ">
                        <span style="visibility: hidden; display: none " class="user_id" id="<?php echo Aquilon::getByKey($message, 'id') ?>-<?php echo Aquilon::getByKey($message, 'user_id') ?>"></span>

                        <div class="col-12 row info-block">
                            <div class="col-xl-11 col-lg-10 col-md-9 col-sm-10 col-xs-12 row">
                                <div class="col-xl-1 col-lg-2 col-md-4 col-sm-3 col-xs-6 col-6 photo-block">
                                    <div class="photo" style="background-image: url('<?php echo Aquilon::getByKey(Aquilon::getByKey($message, 'user'), 'image') ?>')">
                                        <?php echo empty(Aquilon::getByKey(Aquilon::getByKey($message, 'user'), 'image')) ? '<i class="far fa-user-circle photo-not-use"></i>' : "" ?>
                                    </div>
                                </div>
                                <div class="col-xl-11 col-lg-10 col-md-8 col-sm-9 col-xs-6 col-6 author">
                                    <?php echo Aquilon::getByKey(Aquilon::getByKey($message, 'user'), 'name') ?>
                                </div>
                                <small style="margin-top: -10px">
                                    <p>
                                        <?php
                                            if (Aquilon::_SESSION('id')  === Aquilon::getByKey($message, 'user_id')) {
                                                echo "Your message";
                                            } elseif (Aquilon::_SESSION('id')  === Aquilon::getByKey($message, 'reply_user_id')) {
                                                echo 'Was replied to you';
                                            }
                                        ?>
                                    </p>
                                </small>
                            </div>
                            <div class="col-xl-1 col-lg-2 col-md-3 col-sm-2 col-xs-12 actions">
                                <div class="action <?php echo empty($_SESSION) ? 'inactive' : '' ?>" <?php echo !empty($_SESSION) ? 'onclick="openReplyBlock(\'' . Aquilon::getByKey($message, 'id')  . '_' . Aquilon::getByKey($message, 'user_id') . '\')"': '' ?> ">
                                    <small><?php echo empty($_SESSION) ? 'Sign in to' : '' ?></small>
                                    <?php echo empty($_SESSION) ? '<br>' : '' ?>
                                    <span>Reply </span><i class="fas fa-reply"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row text-block">
                            <div class="text">
                                <?php
                                    if (Aquilon::getByKey($message, 'reply_user_id') !== null && Aquilon::getByKey($message, 'reply_user_id') !== 0) {

                                        $reply_message = null;

                                        foreach ($messages as $mes) {
                                            if (Aquilon::getByKey($message, 'reply_message_id') === Aquilon::getByKey($mes, 'id')) {
                                                $reply_message = Aquilon::getByKey($mes, 'message');
                                            }
                                        }

                                        echo '<div class="reply-in-message">';
                                        echo '<a class="reply-link noselect" onclick="goToMessage(this, \''. Aquilon::getByKey($message, 'reply_message_id') . '_' .  Aquilon::getByKey($message, "reply_user_id") .'\')">' . Aquilon::getByKey(Aquilon::getByKey($message, 'user'), 'name') . ',</a>';
                                        echo '<span> ' . $reply_message . '</span><div></div>';
                                        echo '</div>';
                                    }
                                ?>
                                <?php echo Aquilon::getByKey($message, 'message') ?>
                            </div>
                        </div>
                        <div class="col-12 row bottom-block">
                            <div class="col-xl-11 col-lg-10 col-md-9 col-sm-10 col-xs-12 item">
                                <i class="far fa-clock"></i><span><?php echo
                                    StringFilter::filterDate(Aquilon::getByKey($message, 'create_at')) . ' ' . StringFilter::filterTime(Aquilon::getByKey($message, 'create_at'))
                                    ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div style="height: 20px"></div>
        <div id="reply-block" class="container-fluid row disable">
            <div class="message-input col-12">
                <div>Your message</div>
                <textarea id="reply-block-message" name="message"></textarea>
                <button onclick="addReply()" type="button">Write</button>
            </div>
        </div>
    </div>
<?php if (!empty($_SESSION)) : ?>
    <div style="height: 100px"></div>
<?php endif; ?>
</div>
<?php if (!empty($_SESSION)) : ?>
    <div class="message-block">
        <textarea id="message-new" name="message-new"></textarea>
        <i onclick="addMessage()" class="icon fas fa-paper-plane"></i>
    </div>
<?php endif; ?>


<script>
    let reply_id = 0;
    let reply_user_id = 0;

    const sendMessage = (discussionId, userId, message, replyUserId, replyMessageId) =>
        axios.post('http://frm.zzz.com.ua/discussion/message/add',
            {
                discussion_id: discussionId,
                user_id: userId,
                message: message,
                reply_user_id: replyUserId,
                reply_message_id: replyMessageId
            }
        ).then(function (response) {
            return response;
        }).catch(function (error) {
            return error.response;
        });

    const addLike = (discussionId, userId) =>
        fetch("/discussion/like/" + userId + "/" + discussionId, {
            method: "GET",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("Error" + response.statusText);
            })
            .catch(error => console.log(error));

    const removeLike = (discussionId, userId) =>
        fetch("/discussion/dislike/" + userId + "/" + discussionId, {
            method: "GET",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("Error" + response.statusText);
            })
            .catch(error => console.log(error));

    const like = async (el) => {
        let discussionId = '<?php echo Aquilon::getByKey($item, 'id') ?>';
        let userId = '<?php echo Aquilon::_SESSION('id') ?>';

        let count = await addLike(discussionId, userId);

        let el_far = document.getElementById('like-use');
        el_far.classList.remove('like-disable');
        el_far.classList.add('like-active');
        el_far.classList.add('use');
        el.classList.remove('like-active');
        el.classList.add('like-disable');

        document.getElementById('likes-count').innerText = count;
    };

    const dislike = async (el) => {
        let discussionId = '<?php echo Aquilon::getByKey($item, 'id') ?>';
        let userId = '<?php echo Aquilon::_SESSION('id') ?>';

        let count = await removeLike(discussionId, userId);

        let el_fas = document.getElementById('like-not-use');
        el_fas.classList.remove('like-disable');
        el_fas.classList.add('like-active');
        el.classList.remove('like-active');
        el.classList.add('like-disable');

        document.getElementById('likes-count').innerText = count;
    };

    function openReplyBlock(id) {

        if (reply_id  === parseInt(id.split('_')[0])) {
            $( "#reply-block" ).insertAfter( ".header" );
            $( "#reply-block" ).addClass('disable');
            reply_id = null;
        } else {
            reply_id = parseInt(id.split('_')[0]);
            reply_user_id = parseInt(id.split('_')[1]);
            $( "#reply-block" ).insertAfter( "#message-" + id + " .bottom-block" );
            $( "#reply-block" ).removeClass('disable');
        }

    }

    function addReply() {
        addMessage(reply_id, reply_user_id, document.getElementById('reply-block-message').value);
    }

    async function addMessage(reply_message_id = 0, reply_user_id = 0, message = null) {
        let discussionId = '<?php echo Aquilon::getByKey($item, 'id') ?>';
        let userId = '<?php echo Aquilon::_SESSION('id') ?>';

        if (message === null) {
            message = document.getElementById('message-new').value;
        }

        if (message === '') {
            return false;
        }

        let resp = await sendMessage(discussionId, userId, message, reply_user_id, reply_message_id);

        document.location.reload(false);

        console.log(resp);
    }

    function goToMessage(el, id) {

        $("#discussContent").animate({
            scrollTop: $("#message-" + id).offset().top,
        }, 1000);

        if ($("#message-" + id).css('opacity') == 1) {
            $("#message-" + id).css('opacity', 0.5);
            $(el).css('color', 'red');

            setTimeout(function () {
                $("#message-" + id).css('opacity', 1);
                $(el).css('color', '#00a0ff');
            }, 10000)
        } else {
            $("#message-" + id).css('opacity', 1);
            $(el).css('color', '#00a0ff');
        }
    }
</script>