
function show_all()
{
	var str = '';
   var ary = data.items;
   ary.reverse(); // 要顯示的資料反轉

	for(idx in ary)
	{
		item = ary[idx];

		uid     = item.uid;
		title_c = item.title_c;

		// str += '<input type="button" value="刪" onclick="remove('+idx+');"> ';
		str += '《<a href="display.php?uid=' + uid + '">' + title_c + '</a>》 ';
	}
   
   ary.reverse(); // 顯示完要再反轉
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
   var idx_found = 0;
	for(idx in data.items)
	{
		item_one = data.items[idx];
      if(item_one.uid==_uid)
      {
         found = true;
         idx_found = idx;
      }
   }

   if(found)
   {
      data.items.splice(idx_found, 1);
   }

   // 超過數量則移除一項
   if(data.items.length>=data_max)
   {
      data.items.shift();
   }

   // Put the object into storage
   data.items.push(dataObject);
   
   // save
   localStorage.setItem('recent_view', JSON.stringify(data));

   show_all();
}

var data_max = 6;
var data = {items: []};
retrieve_view();
