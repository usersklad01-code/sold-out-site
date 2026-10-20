document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.header-bottom-menu__catalog-button');
    const menu = document.querySelector('.catalog-mega');

    // Функция подбора количества колонок
    function adjustColumnCount(element, maxHeight = 450, maxColumns = 10) {
        if (!element || element.offsetHeight === 0) return;

        let columns = 1;
        element.style.columnCount = columns;
        let height = element.offsetHeight;

        while (height > maxHeight && columns < maxColumns) {
            columns++;
            element.style.columnCount = columns;
            height = element.offsetHeight;
        }
    }

    // Функция для применения колонок к текущему активному блоку
    function applyColumnsToActiveBlock() {
        const activeBlock = document.querySelector('.catalog-mega__right-block.active');
        if (activeBlock) {
            activeBlock.style.columnCount = ''; // сброс перед расчетом
            adjustColumnCount(activeBlock, 450, 10);
        }
    }

    if (buttons.length && menu) {
        function closeMenu() {
            menu.classList.remove('is-open');
            buttons.forEach(btn => btn.classList.remove('is-active'));
            // При закрытии можно сбросить columnCount у всех блоков, но не обязательно
            // document.querySelectorAll('.catalog-mega__right-block').forEach(b => b.style.columnCount = '');
        }

        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('is-open');
                buttons.forEach(btn => btn.classList.remove('is-active'));
                this.classList.toggle('is-active');

                // Если после toggle меню открылось, применяем колонки к активному блоку
                if (menu.classList.contains('is-open')) {
                    applyColumnsToActiveBlock();
                }
            });
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.header-bottom-menu')) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMenu();
            }
        });
    }

    // Если меню изначально открыто (например, класс is-open есть в HTML), применяем колонки
    if (menu && menu.classList.contains('is-open')) {
        applyColumnsToActiveBlock();
    }

    // Обработка наведения на пункты левого меню
    document.querySelectorAll('.catalog-mega__left-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            let id = this.dataset.id;

            document.querySelectorAll('.catalog-mega__left-item')
                .forEach(i => i.classList.remove('active'));

            // Сброс columnCount у всех правых блоков перед активацией нового
            document.querySelectorAll('.catalog-mega__right-block')
                .forEach(block => {
                    block.classList.remove('active');
                    block.style.columnCount = ''; // сброс
                });

            this.classList.add('active');

            let activeBlock = document.querySelector(
                '.catalog-mega__right-block[data-parent="' + id + '"]'
            );

            if (activeBlock) {
                activeBlock.classList.add('active');
                adjustColumnCount(activeBlock, 450, 10);
            }
        });
    });
});