<!-- <div class="row">
    <div class="footer">
        <div><?php //echo date("Y"); ?></div>
    </div>
</div> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).on("input", function (ev) {
        $.ajax({
            type: 'POST',
            url: 'search.php',
            data: {
                question: $("#search").val(),
            },
            success: function (data) {
                $("#output").html(data);
            }
        });
    });
</script>
<!-- <script>
        Swal.fire({
        // icon: 'warning',
        imageUrl: 'img/pte_image.jpg',
        imageHeight: 700,
        confirmButtonText: 'Вперед',
        // text: `Уважаемые друзья, проект поддерживается за счет неравнодушных работников магистрали.`,
        footer: '<a href="http://xpress.by/2016/06/15/pte-po-novomu-umnoe-reshenie-dlya-smartfonov/" target="_blank">Учить ПТЭ</a>'
        })
    </script> -->


</body>

</html>