fetch('./scan.php')
    .then(response => response.json()) // 解析JSON响应
    .then(files => {
        const fileListElement = document.getElementById('file-list');
        fileListElement.innerHTML = ''; // 清空初始内容
        
        // 遍历文件列表，为每个文件创建一个链接
        files.forEach(file => {
            const link = document.createElement('a');
            link.href = file.url;
            link.textContent = file.name;
            fileListElement.appendChild(link);
            fileListElement.appendChild(document.createElement('br')); // 添加换行，使链接显示更清晰
        });
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('file-list').innerHTML = '加载失败';
    });