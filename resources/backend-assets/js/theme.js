let _f = window._s;
(function (window) {

    var sidebarActive = false;
    let sidebarEl = document.querySelector('.page-sidebar');
    let phoneBarsEl = document.querySelector('.mnav__phone-bars');
    let _s = {};
    phoneBarsEl.onclick = _s.toggleSidebar = function () {
        sidebarActive = !sidebarActive;
        sidebarEl.classList.toggle('active');
        if (sidebarEl.classList.contains('active')) {
            phoneBarsEl.classList.add('active');
            if (!document.querySelector('.sidebar-backdrop')) {
                _s.createSidebarBackdrop();
            }
        } else {
            phoneBarsEl.classList.remove('active');
            let backdrop = document.querySelector('.sidebar-backdrop');
            if (backdrop) backdrop.remove();
        }
    }

    _s.createSidebarBackdrop = function () {
        let backdrop = document.createElement('div');
        backdrop.classList.add('sidebar-backdrop');
        backdrop.onclick = function () {
            _s.toggleSidebar();
        };
        document.querySelector('body').appendChild(backdrop);
    }

    $(document).on('change input keyup', ".is-invalid", function () {
        $(this).removeClass('is-invalid');
    });

    $(document).on('input paste', '#price', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $(document).on('change', '#price', function () {
        this.value = parseFloat(this.value).toFixed(2);
    });

    $(document).on('click', '.show-password', function () {
        if ($(this).hasClass('active')) $(this).parent().find('input').attr('type', 'password');
        else $(this).parent().find('input').attr('type', 'text');
        $(this).toggleClass('active');
    });
    $(document).on('submit', '.auth-form form', function () {
        $('.auth-btn').prop('disabled', true);
    });

    _f.setRequiredInputsStar();

    _f.setupDatePicker();
})(window);
