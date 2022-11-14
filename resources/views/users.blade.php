<!DOCTYPE html>
<html lang="en">
    @include('component.header')
    <!-- Section-->
    <section class="py-5">
      <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
          <button type="button" onclick="window.location = '{{route('register')}}'" style="float:right;" class="col btn btn-primary">新增使用者</button>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">使用者帳號</th>
              <th scope="col">預設金鑰</th>
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

    editRow = async function(id) {
      location.href = `edit-user?id=${id}`
    }

    getList = async function() {
        await sendAjax('get', null, function(response) {
          var tbody = document.querySelector('tbody');
          var str = ''
          response.forEach(function (item, index) {
            str += `                    
                <tr>
                  <th scope="row">${ index+1 }</th>
                  <td>${ item.name }</td>
                  <td>${ item.default_token ? item.default_token.name : '無' }</td>
                  <td>
                    <button onclick="dropRow(${ item.id })" type="button" class="btn btn-danger">刪除</button>
                    <button onclick="editRow(${ item.id })" type="button" class="btn btn-success">編輯</button>
                  </td>
                </tr> 
            `
          })
          tbody.innerHTML = str
          return true;
        })
    }

    sendAjax = function(type, data = null, callback = null, id = null, failCallback = function (xhr) {return false;}) {
      url = '/api/users';
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
