<!DOCTYPE html>
<html lang="en">
    @include('component.header')
    <!-- Section-->
    <section class="py-5">
        <input type="hidden" class="defaultToken" value="{{ $user['defaultToken'] ? $user['defaultToken']['id'] : 0 }}">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="input-group">
                <select class="form-select form-select-lg mb-3 tokenId" aria-label=".form-select-lg">
                  <option selected>請選擇要發送訊息的聊天室</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
            </div>
            <div class="input-group">
                <span class="input-group-text">訊息</span>
                <textarea class="form-control message" aria-label="With textarea" style="height:200px"></textarea>
            </div>
            <br>
            <div class="row">
                <button type="button" onclick="reset()" style="float:right;" class="col btn btn-warning">清空</button>
                <button type="button" onclick="pubiishMessage()" style="float:right;" class="col btn btn-primary">發送</button>
            </div>
        </div>
    </section>
    @include('component.footer')
</html>
<script>
    
    $(function() {
      getTokenList();
    });

    reset = function () {
        $('.message').val('');
        $('.tokenId').val(0);
    }

    pubiishMessage = function () {
        let message = $('.message').val();
        let token_id = $('.tokenId').val();
        let name = `{{Auth::user()->name}}`;

        let data = { token_id: token_id, message: message , user: name}
        sendAjax('post', data , function (response) {
            $('.toast-body').html(`訊息發送成功`);
            $('.toast').fadeIn('slow');
          return true;
        });
    };

    getTokenList = function () {
        sendAjax('get', null , function (response) {
            var target =$('.tokenId');
            var defaultTokenId = $('.defaultToken').val();
            var str = '<option value=0 selected>請選擇要發送訊息的聊天室</option>';
            response.forEach(function (item) {
                is_selected = item.id == defaultTokenId ? 'selected' : '';
                str += `                    
                    <option ${is_selected} value="${item.id}">${item.name}</option>
                `
            });
          target.html(str);
          return true;
        });
    }

    sendAjax = function(type, data = null, callback = null, id = null) {
      let url = '/api/publish';
      $.ajax({
            url: url,
            type: type,
            data: data,
            error: function (xhr) {
              return false;
            },
            success: callback
        });
    }
</script>
