<div class="indexContent" onscroll="closeDiscussionMenu(this)">
    <?php $list = $this->getCollection(); ?>
    <?php if (count($list) == 0) : ?>
        <div style="height: 100%; width: 100%; text-align: center; line-height: 100vh; font-size: 20px; color: #b0b0b0">
            No one here, start something)
        </div>
    <?php endif; ?>
    <?php foreach ($list as $key => $item) : ?>
    <div class="discussion-present-block" id="discus-block.<?php echo $key . '.' . Aquilon::getByKey($item, 'id') ?>" onmousemove="openDiscussionMenu(this)">
        <div class="body container-fluid">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-xs-12">
                    <div class="photo" style="background-image: url('<?php echo Aquilon::getByKey($item, 'image') ?>')">
                        <?php echo empty(Aquilon::getByKey($item, 'image')) ? '<i class="fas fa-cat"></i>' : '' ?>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-10 col-md-9 col-sm-9 col-xs-12 description">
                    <div class="title"><?php echo Aquilon::getByKey($item, 'title') ?></div>
                    <div class="author"><?php echo Aquilon::getByKey($item, 'author') ?></div>
                    <div class="row">
                        <div class="data col-6"><i class="far fa-clock"></i><span><?php echo StringFilter::filterDate(Aquilon::getByKey($item, 'create_at')) ?></span></div>
                        <div class="data col-6">
                            <span class="tags-block">
                                <?php if (Aquilon::getByKey($item, 'tags')) : ?>
                                <?php foreach (Aquilon::getByKey($item, 'tags') as $value) : ?>
                                    <span><i class="fas fa-hashtag"><?php echo Aquilon::getByKey($value, 'tag') ?></i></span>
                                <?php endforeach; ?>
                                <?php endif; ?>
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
                        <div id="likes-count.<?php echo Aquilon::getByKey($item, 'id') ?>"><?php echo Aquilon::getByKey($item, "likes") ?></div>
                        <i class="far fa-heart <?php echo Aquilon::getByKey($item, "is_like") ? "like-disable" : "like-active" ?>" id="like-not-use.<?php echo Aquilon::getByKey($item, "id") ?>" onclick="<?php echo Aquilon::_SESSION('id') ? 'like(this)' : '' ?>"></i>
                        <i class="fas fa-heart  <?php echo !Aquilon::getByKey($item, "is_like") ? "like-disable" : "like-active use" ?>" id="like-use.<?php echo Aquilon::getByKey($item, "id") ?>" onclick="<?php echo Aquilon::_SESSION('id') ? 'dislike(this)' : '' ?>"></i>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 20px"></div>
    </div>
    <?php endforeach; ?>

    <div class="open-menu disable" id="open-menu" onclick="openDiscussionPage()">
        <span>OPEN</span>
    </div>
    <?php if (!empty($_SESSION) && count($list) != 0) : ?>
        <div style="height: 130px"></div>
    <?php endif; ?>
</div>

<?php if (!empty($_SESSION)) : ?>
    <form action="http://frm.zzz.com.ua/discussion/add" method="post" enctype="multipart/form-data">
        <div class="new-discuss-block">
            <div class="fileinputs">
                <input type="file" class="file" id="imgInp" name="image"/>
                <div class="fakefile">
                    <button>
                        <i id="image-icon" class="far fa-images"></i>
                        <img id="blah" />
                    </button>
                </div>
            </div>
            <textarea required="required" name="title" class="message-new-text" style="width: " placeholder="Type title"></textarea>
            <textarea required="required" name="tags" class="message-new-tags" style="width: " placeholder="Type tags after coma (,)"></textarea>
            <button class="create-button">CREATE</button>
        </div>
    </form>
<?php endif; ?>

<style>

    .new-discuss-block {
        display: flex;
        width: 100%;
        background-color: #b5b5b5;
        height: 100px;
        position: absolute;
        margin-top: -100px;
    }

    .new-discuss-block .create-button {
        border: none;
        background-color: #b0b0b0;
        color: white;
        width: 300px;
    }

    .new-discuss-block textarea {
        padding: 10px;
        background-color: #eeeeee;
        outline: none;
        border: none;
        resize: none;
    }

    .new-discuss-block .message-new-text {
        width: calc(100% - 200px);
        border-right: 1px dashed #b5b5b5;
    }

    .new-discuss-block .message-new-tags {
        width: 200px;
    }

    div.fileinputs {
        position: relative;
        width: 100px;
        height: 100px;
    }

    div.fakefile {
        position: absolute;
        top: 0px;
        left: 0px;
        z-index: 1;
        width: 100px;
        height: 100px;
    }

    input.file {
        position: relative;
        text-align: right;
        -moz-opacity:0 ;
        filter:alpha(opacity: 0);
        opacity: 0;
        z-index: 2;
        width: 100px;
        height: 100px;
    }

    div.fakefile button {
        width: 100px;
        height: 100px;
        border: none;
        background-color: #dddddd;
        color: white;
        font-size: 30px;
    }

    div.fakefile button img {
        width: 100px;
        height: 100px;
        border: none;
        margin-left: -10px;
        background-color: transparent;
        visibility: hidden;
        display: none;
    }
</style>

<script>
    let disc_id = 0;

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
        let discussionId = el.id.split('.')[1];
        let userId = '<?php echo Aquilon::_SESSION('id') ?>';

        let count = await addLike(discussionId, userId);

        let el_far = document.getElementById('like-use.' + discussionId);
        el_far.classList.remove('like-disable');
        el_far.classList.add('like-active');
        el_far.classList.add('use');
        el.classList.remove('like-active');
        el.classList.add('like-disable');

        document.getElementById('likes-count.' + discussionId).innerText = count;
    };

    const dislike = async (el) => {
        let discussionId = el.id.split('.')[1];
        let userId = '<?php echo Aquilon::_SESSION('id') ?>';

        let count = await removeLike(discussionId, userId);

        let el_fas = document.getElementById('like-not-use.' + el.id.split('.')[1]);
        el_fas.classList.remove('like-disable');
        el_fas.classList.add('like-active');
        el.classList.remove('like-active');
        el.classList.add('like-disable');

        document.getElementById('likes-count.' + discussionId).innerText = count;
    };

    function openDiscussionMenu(el) {
        disc_id = el.id.split('.')[2];
        let open_el = document.getElementById('open-menu');
        open_el.classList.remove('disable');
        open_el.style.marginTop = el.getBoundingClientRect().top+10 + "px"
    }

    function closeDiscussionMenu(el) {
        let open_el = document.getElementById('open-menu');
        open_el.classList.add('disable');
    }

    function openDiscussionPage() {
        window.location.href =  'discussion/open/' + disc_id
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        $('#image-icon').css("visibility", "hidden");
        $('#image-icon').css("display", "none");
        $('#blah').css("visibility", "visible");
        $('#blah').css("display", "block");
        readURL(this);
    });

</script>