</div>

<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

</section>
<!-- JavaScript Libraries -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });

    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            getProductData();
        }
    })

    function getCategoryData() {
        $.ajax({
            url: "<?php echo base_url() ?>seller/getCategories",
            data: {
                'limit_status': true,
                'limit': 20,
                'start_val': 0
            },
            type: "POST",
            success: function(data) {
                console.log(data);
                $("#categoryData").html(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    function getProductData() {
        $(".load-more-btn").remove();
        let start_val = parseInt($("#start_val").val());
        $.ajax({
            url: "<?php echo base_url() ?>seller/getProducts",
            data: {
                'limit': true,
                'start_val': start_val,
                'max_limit': 20
            },
            type: "POST",
            success: function(data) {
                $("#productData").append(data);
                start_val += 20;
                $("#start_val").val(start_val);
            },
            error: function(data) {
                console.log(data);
            }
        })
    }
</script>
</body>

</html>