<!DOCTYPE html>
<html lang="en">
    @include('component.header')
    <!-- Section-->
    <section class="py-5">
        <input type="hidden" class="defaultToken" value="{{ $user['defaultToken'] ? $user['defaultToken']['id'] : 0 }}">
        <input type="hidden" class="userId" value="{{ $user['id'] }}">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">使用者帳號</span>
                </div>
                <input disabled type="text" class="form-control" value={{$user['name']}} id="basic-url" aria-describedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">修改使用者新密碼</span>
                </div>
                <input type="password" class="form-control pwd1" id="basic-url" aria-describedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">二次確認修改使用者密碼</span>
                </div>
                <input type="password" class="form-control pwd2" id="basic-url" aria-describedby="basic-addon3">
            </div>
            <div class="input-group">
                <select class="form-select form-select-lg mb-3 tokenId" aria-label=".form-select-lg">
                  <option selected>請選擇預設聊天室</option>
                </select>
            </div>
            <br>
            <div class="row">
                <button type="button" onclick="history.go(-1)" style="float:right;" class="col btn btn-warning">回到上一頁</button>
                <button type="button" onclick="sendEdit()" style="float:right;" class="col btn btn-primary">確認修改使用者設定</button>
            </div>
        </div>
    </section>
    @include('component.footer')
</html>
<script>
    $(function() {
        getTokenList();
    });

    sendEdit = function () {
        var userId = $('.userId').val();
        var password = $('.pwd1').val();
        var passwordCheck = $('.pwd2').val();
        var tokenId = $('.tokenId').val();
        var editPassword = null;
        if(password !== passwordCheck && password !== '') {
            alert('修改密碼異常,請確認兩次輸入的密碼相同');
            return;
        } else {
            editPassword = password;
        }
        if(tokenId == $('.defaultToken').val() && editPassword == null) {
            alert('沒有檢測到任何修改項目');
        }else{
            let data = { password: editPassword, tokenId: tokenId };
                sendAjax('patch', `/api/user-setting/${userId}`, data , function (response) {
                $('.toast-body').html('修改成功')
                $('.toast').fadeIn('slow');
                $('.pwd1').val('');
                $('.pwd2').val('');
            });
        }

    };

    getTokenList = function () {
        sendAjax('get', '/api/publish', null , function (response) {
            var target = $('.tokenId');
            var tokenId = $('.defaultToken').val();
            var str = '<option value=0 selected>請選擇預設聊天室</option>';
            response.forEach(function (item) {
                is_selected = item.id == tokenId ? 'selected' : '';
                str += `                    
                    <option ${is_selected} value="${item.id}">${item.name}</option>
                `
            });
          target.html(str);
          return true;
        });
    }

    sendAjax = function(type, url, data = null, callback = null, id = null) {
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
