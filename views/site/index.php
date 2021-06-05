<?php

/* @var $this yii\web\View */

/** @var \app\models\ChatMessage $model */

use yii\helpers\Url;

$this->title = 'Чат';
$isAdm = Yii::$app->user->can(\app\models\User::ROLE_ADMIN);
?>
    <div class="card card-primary card-outline direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Общий чат</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages" style="height: 450px;">
                <!-- Message. Default to the left -->
                <?php foreach ($model as $item): ?>
                    <?php if ($item->isStatus() || $isAdm): ?>
                        <div class="direct-chat-msg" <?= !$item->isStatus() ? 'style="opacity: 0.7;"' : '' ?>>
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left"><?= $item->user->login ?></span>
                                <span class="direct-chat-timestamp float-right">
                            <?= Yii::$app->formatter->asDatetime($item->created_at); ?>
                        </span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="/no-img.png" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text d-flex justify-content-between align-content-center <?= $item->isAdmin() ? 'adm' : '' ?>">
                                <span><?= $item->text ?></span>
                                <?php if ($isAdm && $item->isStatus()): ?>
                                    <a href="<?= Url::to(['site/incorrect', 'id' => $item->id]) ?>" class="trash">
                                        <i class="fas fa-minus-circle"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- /.direct-chat-msg -->
            </div>
            <!--/.direct-chat-messages-->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <?php if (!Yii::$app->user->isGuest): ?>
                <form action="<?= \yii\helpers\Url::to(['site/new-message']) ?>" method="post">
                    <div class="input-group">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                               value="<?= Yii::$app->request->getCsrfToken() ?>"/>

                        <input type="text" name="message" placeholder="Новое сообщение ..." class="form-control">
                        <span class="input-group-append">
                      <button type="submit" class="btn btn-primary">Send</button>
                    </span>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <!-- /.card-footer-->
    </div>

<?php
$script = <<<JS
$('.direct-chat-messages').scrollTop($('.direct-chat-messages').innerHeight());
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>