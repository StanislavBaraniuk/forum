<?php

    class DiscussionModel extends Model
    {
        public function getCollection () {

            $discussions = $this->query(
                SQL::SELECT(
                    ["GET" => ["*"], ""],
                    0,
                    'discussions'
                )
            );

            $tags = $this->query(SQL::SELECT(["GET" => ['*']], 0, 'tags'));

            foreach ($discussions as &$discussion) {

                foreach ($tags as &$tag) {

                    if (Aquilon::getByKey($tag, 'discussion_id') === Aquilon::getByKey($discussion, 'id')) {
                        $discussion['tags'][] = $tag;
                    }

                }

                $author =  $this->query(
                    SQL::SELECT(
                        [
                            "GET" => ['name'],
                            "WHERE" => ['id' => Aquilon::getByKey($discussion, 'user_id')]
                        ],
                        0,
                        'users'
                    )
                );

                if (!empty($author[0])) {
                    $discussion['author'] = $author[0]['name'];

                    $discussion['messages_count'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(ID)'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id')]
                            ],
                            0,
                            'messages'))[0]['COUNT(ID)'];

                    $discussion['users_count'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(DISTINCT user_id)'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id')]
                            ],
                            0,
                            'messages'))[0]['COUNT(DISTINCT user_id)'];

                    $discussion['likes'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(id)'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id')]
                            ],
                            0,
                            'likes'))[0]['COUNT(id)'];

                    $discussion['is_like'] = !empty($this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['id'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id'),
                                    "user_id" => Aquilon::_SESSION('id')]
                            ],
                            0,
                            'likes'))[0]);

                } else  {
                    return null;
                }
            }



            return $discussions;
        }

        public function getItem ( $id ) {

            $discussion = $this->query(
                SQL::SELECT(
                    ["GET" => ["*"], "WHERE" => ['id' => $id]],
                    0,
                    'discussions'
                )
            );

            $tags = $this->query(SQL::SELECT(["GET" => ['*']], 0, 'tags'));
            $messages = $this->query(
                SQL::SELECT(
                    [
                        "GET" => ['*'], "WHERE" => ['discussion_id' => $id]
                    ],
                    0,
                    'messages',
                    'ORDER BY create_at DESC'
                )
            );


            if (!empty($discussion[0])) {

                foreach ($tags as &$tag) {
                    if (Aquilon::getByKey($tag, 'discussion_id') === Aquilon::getByKey($discussion[0], 'id')) {
                        $discussion[0]['tags'][] = $tag;
                    }
                }

                $author =  $this->query(
                    SQL::SELECT(
                        [
                            "GET" => ['name'],
                            "WHERE" => ['id' => Aquilon::getByKey($discussion[0], 'user_id')]
                        ],
                        0,
                        'users'
                    )
                );

                foreach ($messages as &$message) {

                    $user = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['id', 'name', 'image'],
                                "WHERE" => ["id" => Aquilon::getByKey($message, 'user_id')]
                            ],
                            0,
                            'users'));

                    $message['user'] = Aquilon::getByKey($user, 0);
                }

                if (!empty($author[0])) {

                    $discussion[0]['author'] = $author[0]['name'];

                    $discussion[0]['messages_count'] = count($messages);

                    $discussion[0]['users_count'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(DISTINCT user_id)'], "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion[0], 'id')]
                            ],
                            0,
                            'messages'))[0]['COUNT(DISTINCT user_id)'];



                    $discussion[0]['likes'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(id)'], "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion[0], 'id')]
                            ],
                            0,
                            'likes'))[0]['COUNT(id)'];

                    $discussion[0]['is_like'] = !empty($this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['id'], "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion[0], 'id'), "user_id" => Aquilon::_SESSION('id')]
                            ],
                            0,
                            'likes'
                        )
                    )[0]);

                } else  {
                    return null;
                }

            }

            return array('discussion' => Aquilon::getByKey($discussion, 0), 'messages' => $messages);
        }

        public function addView ( $id ) {

            $this->query("UPDATE discussions SET views = views + 1 WHERE `id` = '$id'");
        }

        public function addLike ( $discussion_id, $user_id ) {

            if (!$this->isLike($discussion_id, $user_id)) {
                $this->query( SQL::INSERT( [ 'discussion_id' => $discussion_id , 'user_id' => $user_id ] , 0 , 'likes' ) );
            } else {
                return null;
            }

            return true;
        }

        public function removeLike ($discussion_id, $user_id) {

            if ($this->isLike($discussion_id, $user_id)) {
                $this->query( SQL::DELETE( [ 'discussion_id' => $discussion_id , 'user_id' => $user_id ] , 0 , 'likes' ) );
            } else {
                return null;
            }

            return true;
        }

        public function getLikesCount ($discussion_id) {
            return $this->query(
                SQL::SELECT(
                    [
                        "GET" => ['COUNT(id)'], "WHERE" => ['discussion_id' => $discussion_id]
                    ],
                    0,
                    'likes')
            )[0]['COUNT(id)'];
        }

        public function isLike ( $discussion_id, $user_id ) {
            return $this->query(
                    SQL::SELECT(
                        [
                            "GET" => ['COUNT(id)'], "WHERE" => ['discussion_id' => $discussion_id, 'user_id' => $user_id]
                        ],
                        0,
                        'likes')
                )[0]['COUNT(id)'] > 0;
        }

        public function addMessage(array $message) {

            $require = [
                "discussion_id",
                "user_id",
                "message",
                "reply_user_id",
                "reply_message_id"
            ];

            foreach ($require as $item) {
                if (!isset($message[$item])) {
                    return false;
                }
            }

            return empty($this->query(
                SQL::INSERT(
                    [
                        "discussion_id" => Aquilon::getByKey($message, 'discussion_id'),
                        "user_id" => Aquilon::getByKey($message, 'user_id'),
                        "message" => Aquilon::getByKey($message,'message'),
                        "create_at" => ( new DateTime('now', new DateTimeZone('GMT')) )
                            ->format('Y-m-d H:i'),
                        "reply_user_id" => Aquilon::getByKey($message, 'reply_user_id'),
                        "reply_message_id" => Aquilon::getByKey($message, 'reply_message_id')
                    ],
                    0,
                    'messages')
            ));
        }

        public function addDiscussion(array $discussion) {

            $require = [
                "user_id",
                "title",
                "image",
                "tags"
            ];

            foreach ($require as $item) {
                if (!isset($discussion[$item])) {
                    return false;
                }
            }

            $date = ( new DateTime('now', new DateTimeZone('GMT')) )
                ->format('Y-m-d H:i');

            $this->query(
                SQL::INSERT(
                    [
                        "user_id" => Aquilon::getByKey($discussion, 'user_id'),
                        "title" => Aquilon::getByKey($discussion,'title'),
                        "create_at" => $date,
                        'image' => Aquilon::getByKey($discussion,'image')
                    ],
                    0,
                    'discussions'
                    )
            );

            $discussion_id = $this->query(
                SQL::SELECT(
                    [
                        "GET" => ["id"],
                        "WHERE" => [
                            "user_id" => Aquilon::getByKey($discussion, 'user_id'),
                            "title" => Aquilon::getByKey($discussion,'title'),
                            "create_at" => $date
                        ]
                    ],
                    0,
                    'discussions'
                )
            )[0]['id'];

            if ($discussion_id) {
                foreach (explode(',', $discussion['tags']) as $item) {
                     $this->query(
                       SQL::INSERT(
                            [
                                "discussion_id" => $discussion_id,
                                "tag" => $item
                            ],
                            0,
                            'tags')
                    );
                }

                return $discussion_id;
            }

            return false;
        }

        public function getCollectionByFilter (array $filter) {
            $discussions = $this->query(
                SQL::SELECT(
                    ["GET" => ["*"], 'WHERE' => $filter],
                    0,
                    'discussions'
                )
            );

            $tags = $this->query(SQL::SELECT(["GET" => ['*']], 0, 'tags'));

            foreach ($discussions as &$discussion) {

                foreach ($tags as &$tag) {

                    if (Aquilon::getByKey($tag, 'discussion_id') === Aquilon::getByKey($discussion, 'id')) {
                        $discussion['tags'][] = $tag;
                    }

                }

                $author =  $this->query(
                    SQL::SELECT(
                        [
                            "GET" => ['name'],
                            "WHERE" => ['id' => Aquilon::getByKey($discussion, 'user_id')]
                        ],
                        0,
                        'users'
                    )
                );

                if (!empty($author[0])) {
                    $discussion['author'] = $author[0]['name'];

                    $discussion['messages_count'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(ID)'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id')]
                            ],
                            0,
                            'messages'))[0]['COUNT(ID)'];

                    $discussion['users_count'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(DISTINCT user_id)'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id')]
                            ],
                            0,
                            'messages'))[0]['COUNT(DISTINCT user_id)'];

                    $discussion['likes'] = $this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['COUNT(id)'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id')]
                            ],
                            0,
                            'likes'))[0]['COUNT(id)'];

                    $discussion['is_like'] = !empty($this->query(
                        SQL::SELECT(
                            [
                                "GET" => ['id'],
                                "WHERE" => ['discussion_id' => Aquilon::getByKey($discussion, 'id'),
                                    "user_id" => Aquilon::_SESSION('id')]
                            ],
                            0,
                            'likes'))[0]);

                } else  {
                    return null;
                }
            }



            return $discussions;
        }

        public function getByLikes () {

            $likes = $this->query(
                SQL::SELECT(["GET" => ["discussion_id"], "WHERE" => ["user_id" => Aquilon::_SESSION('id')]], 0, 'likes')
            );

            $discussions = array();

            foreach ($likes as $like) {

                $discussion = $this->query(
                    SQL::SELECT(["GET" => ["*"], "WHERE" => ["id" => $like['discussion_id']]], 0, 'discussions')
                );

                array_push($discussions, Aquilon::getByKey($discussion, 0));
            }

            return $discussions;
        }

        public function deleteDiscussion($id) {

            $this->query(
                SQL::DELETE(
                    [
                        "id" => $id,
                    ],
                    0,
                    'discussions'
                )
            );

            $this->query(
                SQL::DELETE(
                    [
                        "discussion_id" => $id,
                    ],
                    0,
                    'likes'
                )
            );

            $this->query(
                SQL::DELETE(
                    [
                        "discussion_id" => $id,
                    ],
                    0,
                    'tags'
                )
            );

            $this->query(
                SQL::DELETE(
                    [
                        "discussion_id" => $id,
                    ],
                    0,
                    'messages'
                )
            );
        }

    }

