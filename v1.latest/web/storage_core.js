// 初始定義
var storage_data = {items: []};
storage_retrieve();  // 取出

function guid()
{
	var max_value = 0;
	for(idx in storage_data.items)
	{
		item_one = storage_data.items[idx];
		id = item_one.id;
		if(id>max_value)
		{
			max_value = id;
		}
	}

    return (max_value+1);
}


function storage_add(uid, title)
{
	var id = guid();

	var item_one = { id:id, uid:uid, title:title };
	storage_data.items.push(item_one);
	storage_save();
}


function storage_remove(idx)
{
	if(idx != -1)
	{
		storage_data.items.splice(idx, 1);
	}
	storage_save();
}


function storage_save()
{
    localStorage.my_film_sotrage = JSON.stringify(storage_data);
}


function storage_retrieve()
{
    if (localStorage.getItem("my_film_sotrage") === null)
    {
		storage_data = {items: []};
		localStorage.my_film_sotrage = JSON.stringify(storage_data);
    }
	
	storage_data = JSON.parse(localStorage.my_film_sotrage);
}


function storage_clear()
{
	storage_data = {items: []};
    localStorage.removeItem("my_film_sotrage");
}
