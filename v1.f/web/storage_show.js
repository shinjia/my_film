// 這裡的 Javascript 在每個動作執行完之後都要立即顯示 (storage_show_all();)

var storage_data = {items: []};
storage_retrieve();  // 取出
storage_show_all();  // 顯示

document.getElementById('btn_clear').onclick = function(){ storage_clear(); storage_show_all(); }


function storage_show_all()
{
	console.log(storage_data);
    var str = '';
	str += '<ul style="text-align:left;">';
	for(idx in storage_data.items)
	{
		item_one = storage_data.items[idx];

		id    = item_one.id;
		uid   = item_one.uid;
		title = item_one.title;

        str += '<li>';
		str += '<input type="button" value="刪" onclick="storage_remove('+idx+'); storage_show_all();">';
		str += '<a href="display.php?uid=' + uid + '">' + title + '</a>';
        str += '</li>';
	}
    str += '</ul>';

	document.getElementById('display').innerHTML = str;
}

function show_content()
{
    let key_list = '';
    if(storage_data.items==0)
    {
        alert('暫存區是空的');
    }
    else
    {
        for(idx in storage_data.items)
        {
            item_one = storage_data.items[idx];

            id    = item_one.id;
            uid   = item_one.uid;
            title = item_one.title;

            key_list += uid + ',';
        }
        key_list = key_list.slice(0, -1) // 移除最後一個逗號
        
        var url = 'list_by.php?type=STORAGE&key=' + key_list;
        window.location.href = url;
    }

}