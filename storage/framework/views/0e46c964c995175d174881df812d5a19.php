

<?php $__env->startSection('title', 'Чат поддержки'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="support-chat-page">

        
        <div class="support-sidebar">

            <div class="support-sidebar-header">
                <h2>Поддержка</h2>

                <a href="<?php echo e(route('support.index')); ?>">
                    ← Назад
                </a>
            </div>

            <div class="support-sidebar-list">

                <?php $__currentLoopData = $allChats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <a href="<?php echo e(route('support.chat', $item->id)); ?>"
                       class="support-sidebar-item
                       <?php echo e($chat->id === $item->id ? 'active' : ''); ?>">

                        <div class="support-sidebar-subject">
                            <?php echo e($item->subject ?? 'Без темы'); ?>

                        </div>

                        <div class="support-sidebar-message">

                            <?php if($item->message->last()): ?>
                                <?php echo e(\Illuminate\Support\Str::limit($item->message->last()->message, 40)); ?>

                            <?php else: ?>
                                Нет сообщений
                            <?php endif; ?>

                        </div>

                    </a>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>

        
        <div class="support-chat">

            
            <div class="support-chat-header">

                <div>

                    <h2>
                        <?php echo e($chat->subject ?? 'Чат поддержки'); ?>

                    </h2>

                    <div class="support-chat-status">

                        Статус:

                        <span id="supportChatStatus" class="<?php echo e($chat->status); ?>">
                            <?php echo e(strtoupper($chat->status_label)); ?>

                        </span>

                    </div>

                </div>

            </div>

            
            <div class="support-messages"
                id="chat-box"
                data-url="<?php echo e(route('support.messages', $chat->id)); ?>">

                <?php echo $__env->make('profile.support.partials.messages', [
                    'messages' => $chat->message
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            </div>

            
            <?php if($chat->status !== 'closed'): ?>

                <form action="<?php echo e(route('support.send.ajax', $chat->id)); ?>"
      method="POST"
      class="support-form"
      id="supportChatForm">

    <?php echo csrf_field(); ?>

    <textarea name="message"
              placeholder="Введите сообщение..."
              required></textarea>

    <button type="submit">
        Отправить
    </button>

</form>

            <?php else: ?>

                <div class="support-chat-closed">
                    Чат закрыт
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>




<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch('<?php echo e(route('notifications.markByData')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            type: 'support_message',
            key: 'chat_id',
            value: '<?php echo e($chat->id); ?>'
        })
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatBox = document.getElementById('chat-box');
    const supportChatForm = document.getElementById('supportChatForm');
    const supportChatStatus = document.getElementById('supportChatStatus');

    function scrollSupportChatToBottom() {
        if (!chatBox) return;
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function loadSupportMessages() {
    if (!chatBox) return;

    const isNearBottom =
        chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < 80;

    fetch(chatBox.dataset.url, {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (chatBox.innerHTML !== data.html) {
                chatBox.innerHTML = data.html;

                if (isNearBottom) {
                    scrollSupportChatToBottom();
                }
            }

            if (supportChatStatus && data.status) {
                supportChatStatus.className = data.status;
                supportChatStatus.innerText = data.status_label;
            }
        });
}

    if (supportChatForm) {
        supportChatForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(supportChatForm);
            const textarea = supportChatForm.querySelector('textarea');

            fetch(supportChatForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(() => {
                    textarea.value = '';
                    loadSupportMessages();
                });
        });
    }

    scrollSupportChatToBottom();
    loadSupportMessages();
    setInterval(loadSupportMessages, 3000);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/support/chat.blade.php ENDPATH**/ ?>