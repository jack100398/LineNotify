<!DOCTYPE html>
<html lang="en">
    @include('component.header')
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
          <table class="table table-striped">
              <thead >
                <tr>
                  <th style="width:10%" scope="col">#</th>
                  <th style="width:20%" scope="col">發送人</th>
                  <th style="width:20%" scope="col">聊天室</th>
                  <th style="width:30%" scope="col">訊息</th>
                  <th style="width:20%" scope="col">發送時間</th>
                </tr>
              </thead>
              <tbody>
                  
              </tbody>
          </table>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item"><a class="page-link add" onclick="changePage('add')">上一頁</a></li>
              <li class="page-item"><a class="page-link reduce" onclick="changePage('reduce')">下一頁</a></li>
            </ul>
          </nav>
        </div>    
    </section>
    @include('component.footer')
</html>
<script>
    let page = 1;

    $(function() {
      getList();
    });

    changePage = async function (type) {
      $('.page-item').addClass('disabled');
      if (type === 'add') {
        if(page - 1 > 0) {
          page -= 1;
        } else {
          $('.toast-body').html('已到達第一頁');
          $('.toast').fadeIn('slow');
        }
      } else if (type === 'reduce') {
          page += 1;
      }

      await getList(true);
      $('.page-item').removeClass('disabled');
    }

    getList = async function(isChange = false) {
        await sendAjax('get', null, function(response) {
          data = response.data;
          if(data.length === 0 && isChange) {
            $('.toast-body').html('已到達最後一頁');
            $('.toast').fadeIn('slow');
            page -= 1
            return;
          }
          var tbody = document.querySelector('tbody');
          var str = ''
          data.forEach(function (item, index) {
            str += `                    
                <tr>
                  <th scope="row">${ index + 1 }</th>
                  <td>${ item.name }</td>
                  <td>${ item.chat_name }</td>
                  <td>
                    <div title=${ item.message }> ${item.message.substr(0,30)} </div>
                  </td>
                  <td>${ item.created_at }</td>
                </tr> 
            `
          })
          tbody.innerHTML = str
          return true;
        })
    }

    sendAjax = function(type, data = null, callback = null, id = null, failCallback = function (xhr) {return false;}) {
      url = '/api/history';
      url += `/?page=${page}`;
      $.ajax({
            url: url,
            type: type,
            data: data,
            error: failCallback,
            success: callback
        });
    }
</script>
