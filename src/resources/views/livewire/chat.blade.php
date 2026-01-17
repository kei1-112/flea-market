<div class="modal">
    <div class="modal__inner">
        <div class="modal__header">
            取引が完了しました。
        </div>

        <div class="modal__horizon-line"></div>

        <div class="modal__content">
            <div class="modal__content--text">
                今回の取引相手はどうでしたか？
            </div>
            <form action="/evaluation" method="post">
                @csrf
                <input type="hidden" name="evaluation" id="evaluationValue">
                <input type="hidden" value="{{ $userId }}" name="userId">
                <input type="hidden" value="{{ $orderId }}" name="orderId">
                <div class="modal__evaluation">
                    <div class="rating">
                        <span class="star" data-value="1">★</span>
                        <span class="star" data-value="2">★</span>
                        <span class="star" data-value="3">★</span>
                        <span class="star" data-value="4">★</span>
                        <span class="star" data-value="5">★</span>
                    </div>
                </div>
                <div class="modal__horizon-line"></div>
                <div class="modal__footer">
                    <button type="submit" class="modal__button--submit">送信する</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    const input = document.getElementById('evaluationValue');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = star.dataset.value;
            input.value = value;

            stars.forEach(s => {
                s.classList.toggle(
                    'active',
                    s.dataset.value <= value
                );
            });
        });
    });
});
</script>