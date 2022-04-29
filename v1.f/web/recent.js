
function show_all()
{
	var str = '';
	for(idx in data.items)
	{
		item_one = data.items[idx];

		uid     = item_one.uid;
		title_c = item_one.title_c;

		// str += '<input type="button" value="刪" onclick="remove('+idx+');"> ';
		str += '《<a href="display.php?uid=' + uid + '">' + title_c + '</a>》 ';
	}
	document.getElementById('recent_view').innerHTML = str;
}

function retrieve_view()
{
   data = JSON.parse(localStorage.recent_view);
   show_all();
}

function save_view(_uid, _title_c)
{
   var dataObject = { uid: _uid, title_c: _title_c };

   // 先檢查是否已存在
   var found = false;
	for(idx in data.items)
	{
		item_one = data.items[idx];
      if(item_one.uid==_uid) found = true;
   }

   if(!found)
   {
      // 超過數量則移除一項
      if(data.items.length>=data_max)
      {
         data.items.shift();
      }

      // Put the object into storage
      data.items.push(dataObject);

      var str1 = JSON.stringify(data);
      localStorage.setItem('recent_view', str1);
   }
   show_all();
}

var data_max = 6;
var data = {items: []};
retrieve_view();
