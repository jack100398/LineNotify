<!DOCTYPE html>
<html lang="en">
    @include('component.header')
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span id='abc' class="input-group-text" id="basic-addon3">聊天室名稱</span>
                </div>
                <input type="text" class="form-control chat_name" id="basic-url" aria-describedby="basic-addon3">
            </div>       

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">機器人金鑰</span>
                </div>
                <input type="text" class="form-control robot_token" id="basic-url" aria-describedby="basic-addon3">
            </div>
            <div class="row">
                <button type="button" onclick="create()" style="float:right;" class="col btn btn-primary">新增機器人</button>
            </div>
        </div>

        <div class="container px-4 px-lg-5 mt-5"><table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">聊天室名稱</th>
                    <th scope="col">機器人金鑰</th>
                    <th scope="col">操作</th>
                  </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>    
    </section>
    @include('component.footer')
</html>
<script>
    $(function() {
      getList();
    });

    create = async function () {
        let chat_name = $('.chat_name').val();
        let robot_token = $('.robot_token').val();
        let data = { robot_token: robot_token, chat_name: chat_name };
        await sendAjax('post', data, async function(response) {
          $('.toast-body').html('新增成功')
          $('.toast').fadeIn('slow');
          await getList();
        },
        null,
        function (response) {
          $('.toast-body').html('新增失敗,請確認輸入資料');
          $('.toast').fadeIn('slow');;
        });
    }

    dropRow = async function(id) {
      await sendAjax('delete', null,
        function (response) {
          $('.toast-body').html('刪除成功')
          $('.toast').fadeIn('slow');
        },
        id,
        function (response) {
          $('.toast-body').html('刪除失敗,請確認輸入資料');
          $('.toast').fadeIn('slow');;
        });
        await getList();
    }

    getList = async function() {
        await sendAjax('get', null, function(response) {
          var tbody = document.querySelector('tbody');
          var str = ''
          response[0].forEach(function (item) {
            str += `                    
                <tr>
                  <th scope="row">${ item.id }</th>
                  <td>${ item.name }</td>
                  <td>${ item.token }</td>
                  <td><button onclick="dropRow(${ item.id })" type="button" class="btn btn-danger" {{ Auth::user()->name === 'admin' ? '' : 'hidden' }}>刪除</button></td>
                </tr> 
            `
          })
          tbody.innerHTML = str
          return true;
        })
    }

    sendAjax = function(type, data = null, callback = null, id = null, failCallback = function (xhr) {return false;}) {
      url = '/api/setting';
      if ( id !== null) {
        url += `/${id}`;
      }
      $.ajax({
            url: url,
            type: type,
            data: data,
            error: failCallback,
            success: callback
        });
    }
</script>
