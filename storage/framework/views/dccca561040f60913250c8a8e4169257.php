

<?php $__env->startSection('title', 'Заказ #' . $order->id); ?>
<?php $__env->startSection('page-title', 'Заказ #' . $order->id); ?>
<?php $__env->startSection('page-subtitle', 'Карточка заказа и чат с клиентом'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-order-layout">

    <div class="admin-form-card">

        <div class="admin-order-top">
            <h3>Информация о заказе</h3>

            <?php if($order->status === 'confirmed'): ?>
                <span class="admin-status admin-status--success">Подтверждён</span>
            <?php elseif($order->status === 'new'): ?>
                <span class="admin-status admin-status--warning">Новый</span>
            <?php else: ?>
                <span class="admin-status"><?php echo e($order->status); ?></span>
            <?php endif; ?>
        </div>

        <div class="admin-info-list">
            <div>
                <span>Клиент</span>
                <strong><?php echo e($order->user->name ?? 'Удалён'); ?></strong>
            </div>

            <div>
                <span>Email</span>
                <strong><?php echo e($order->user->email ?? '-'); ?></strong>
            </div>

            <div>
                <span>Телефон</span>
                <strong><?php echo e($order->user->phone ?? '-'); ?></strong>
            </div>

            <div>
                <span>Дата заказа</span>
                <strong><?php echo e($order->created_at->format('d.m.Y H:i')); ?></strong>
            </div>
        </div>

        <h3 class="admin-section-title">Товары</h3>

        <div class="admin-order-products">
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="admin-order-product">
                    <div>
                        <strong><?php echo e($item->product->title ?? 'Удалён товар'); ?></strong>
                        <span>x<?php echo e($item->qty); ?></span>
                    </div>

                    <strong><?php echo e(number_format($item->price, 0, ',', ' ')); ?> ₽</strong>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="admin-order-total">
            <span>Итого</span>
            <strong><?php echo e(number_format($order->total_price, 0, ',', ' ')); ?> ₽</strong>
        </div>

        <?php if($order->status !== 'confirmed'): ?>
            <form action="<?php echo e(route('admin.orders.confirm', $order->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button class="admin-btn">
                    Подтвердить заказ
                </button>
            </form>
        <?php endif; ?>

    </div>

    <div class="admin-chat-panel">

        <div class="admin-chat-panel__head">
            <div>
                <h3>Чат с клиентом</h3>
                <p>Сообщения по заказу #<?php echo e($order->id); ?></p>
            </div>
        </div>

        <div class="admin-chat-panel__body"
             id="adminOrderChatMessages"
             data-url="<?php echo e(route('admin.orders.messages', $order->id)); ?>">

            <?php if($order->chat && $order->chat->message->count()): ?>
                <?php echo $__env->make('admin.orders.partials.messages', [
                    'messages' => $order->chat->message
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <div class="admin-chat-empty">
                    Сообщений пока нет
                </div>
            <?php endif; ?>

        </div>

        <form action="<?php echo e(route('admin.orders.message', $order->id)); ?>"
              method="POST"
              class="admin-chat-panel__form"
              id="adminOrderChatForm">

            <?php echo csrf_field(); ?>

            <textarea name="message" placeholder="Написать клиенту..." required></textarea>

            <button class="admin-btn">
                Отправить
            </button>

        </form>

    </div>

</div>

<script>
const adminChatBox = document.getElementById('adminOrderChatMessages');
const adminChatForm = document.getElementById('adminOrderChatForm');

let lastAdminChatHtml = '';

function scrollAdminChatToBottom() {
    if (!adminChatBox) return;
    adminChatBox.scrollTop = adminChatBox.scrollHeight;
}

function loadAdminOrderMessages() {
    if (!adminChatBox) return;

    const isNearBottom =
        adminChatBox.scrollHeight
        - adminChatBox.scrollTop
        - adminChatBox.clientHeight < 80;

    fetch(adminChatBox.dataset.url, {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (lastAdminChatHtml !== data.html) {
                lastAdminChatHtml = data.html;
                adminChatBox.innerHTML = data.html;

                if (isNearBottom) {
                    scrollAdminChatToBottom();
                }
            }
        });
}

if (adminChatForm) {
    adminChatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(adminChatForm);
        const textarea = adminChatForm.querySelector('textarea');

        fetch(adminChatForm.action, {
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
                loadAdminOrderMessages();
            });
    });
}

scrollAdminChatToBottom();
loadAdminOrderMessages();
setInterval(loadAdminOrderMessages, 3000);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>