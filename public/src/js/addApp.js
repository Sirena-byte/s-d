 // Получаем ссылки на элементы DOM
    const fileInput = document.getElementById('fileInput'); // Скрытый input для выбора файла
    const removeFileButton = document.getElementById('removeFileButton'); // Кнопка удаления файла
    const fileInfo = document.getElementById('fileInfo'); // Блок для отображения информации о файле
    const textArea = document.getElementById('textArea'); // Редактируемая текстовая область
    const placeholder = document.querySelector('.placeholder'); // Плейсхолдер "Введите текст..."

    // Обработчик для кастомной кнопки выбора файла
    document.getElementById('customFileButton').addEventListener('click', function() {
        fileInput.click(); // Имитируем клик по скрытому input[type="file"]
    });

    // Обработчик изменения выбранного файла
    fileInput.addEventListener('change', function() {
        console.log(fileInput.files); // Отладочный вывод выбранных файлов
        
        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name; // Получаем имя первого выбранного файла
            fileInfo.textContent = fileName; // Показываем имя файла
            removeFileButton.style.display = 'inline'; // Показываем кнопку удаления
        } else {
            fileInfo.textContent = ''; // Очищаем информацию о файле
            removeFileButton.style.display = 'none'; // Скрываем кнопку удаления
        }
    });

    // Обработчик для кнопки удаления файла
    removeFileButton.addEventListener('click', function() {
        fileInput.value = ''; // Сбрасываем значение input
        fileInfo.textContent = ''; // Очищаем отображение имени файла
        removeFileButton.style.display = 'none'; // Скрываем кнопку удаления
    });

    // Обработчик вставки контента в текстовую область
    textArea.addEventListener('paste', function(event) {
        const items = (event.clipboardData || window.clipboardData).items; // Получаем данные из буфера
        
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            
            // Проверяем, что вставленный элемент - изображение
            if (item.kind === 'file' && item.type.startsWith('image/')) {
                const file = item.getAsFile(); // Получаем файл изображения
                const reader = new FileReader(); // Создаем FileReader
                
                reader.onload = function(e) {
                    // Создаем элемент изображения
                    const img = document.createElement('img');
                    img.src = e.target.result; // Устанавливаем Data URL
                    img.style.maxWidth = '100%'; // Ограничиваем размер
                    img.style.display = 'block'; // Блочное отображение
                    
                    // Вставляем изображение в позицию курсора
                    const selection = window.getSelection();
                    const range = selection.getRangeAt(0);
                    try {
                        range.insertNode(img); // Вставляем изображение
                    } catch (error) {
                        console.error("Ошибка при вставке изображения:", error);
                        alert("Не удалось вставить изображение.");
                    }
                    range.collapse(false); // Сдвигаем курсор за изображение
                };
                
                reader.readAsDataURL(file); // Читаем файл как Data URL
                event.preventDefault(); // Отменяем стандартное поведение
            }
        }
    });

    // Обработчик ввода текста для управления плейсхолдером
    textArea.addEventListener('input', function() {
        placeholder.style.display = textArea.textContent.trim() === '' 
            ? 'block' // Показываем плейсхолдер если текст пустой
            : 'none'; // Скрываем плейсхолдер
    });

    // Обработчики фокуса/потери фокуса для плейсхолдера
    textArea.addEventListener('focus', function() {
        placeholder.style.display = 'none'; // Скрываем плейсхолдер при фокусе
    });
    
    textArea.addEventListener('blur', function() {
        if (textArea.textContent.trim() === '') {
            placeholder.style.display = 'block'; // Показываем плейсхолдер если текст пустой
        }
    });

    // Функция для подготовки и отправки формы
    function submitForm() {
        const message = textArea.innerHTML; // Получаем HTML-содержимое
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'message'; // Имя поля для сервера
        hiddenInput.value = message; // Устанавливаем значение
        
        // Добавляем скрытое поле в форму
        textArea.parentNode.appendChild(hiddenInput);
        return true; // Разрешаем отправку формы
    }