(function(window){
    var sidebarActive = false;
    let sidebarEl = document.querySelector('.page-sidebar');
    let phoneBarsEl = document.querySelector('.mnav__phone-bars');
    let _s = {};
    phoneBarsEl.onclick = _s.toggleSidebar = function(){
        sidebarActive = !sidebarActive;
        sidebarEl.classList.toggle('active');
        if(sidebarEl.classList.contains('active')){
            phoneBarsEl.classList.add('active');
            if(!document.querySelector('.sidebar-backdrop')){
                _s.createSidebarBackdrop();
            }
        }else{
            phoneBarsEl.classList.remove('active');
            let backdrop = document.querySelector('.sidebar-backdrop');
            if(backdrop) backdrop.remove();
        }
    }

    _s.createSidebarBackdrop = function(){
        let backdrop = document.createElement('div');
        backdrop.classList.add('sidebar-backdrop');
        backdrop.onclick = function(){
            _s.toggleSidebar();
        };
        document.querySelector('body').appendChild(backdrop);
    }

    $(document).on('change input keyup', ".is-invalid", function(){
        $(this).removeClass('is-invalid');
    });

    setRequiredInputsStar();

    setupDatePicker();
})(window);
