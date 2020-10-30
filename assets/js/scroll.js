        document.addEventListener('click', function(event) {
            let modal = document.querySelector('body.tl-ааа-activ');
            let html = document.querySelector('html');
            if (modal != null) {
                console.log("ДА");
                // html.classList.add('no-scroll-y');
                html.style.overflow = "hidden";
            } else {
                console.log("НЕТ");
                // html.classList.remove('no-scroll-y');
                html.style.overflow = "scroll";
            }
        });