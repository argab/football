# football
challenge2

=====

**ЗАДАНИЕ**

Необходимо создать простую программу, предсказывающую исход футбольного матча. Без front-end.
1. На основе таблицы выступления сборных на ЧМ, нужно рассчитать условную мощность атаки и обороны каждой команды. Как именно рассчитывать мощность – решать вам.
Таблица с данными в документе data.php.
2) Необходимо создать функцию match($c1, $c2).
 Входные параметры: $c1, $c2 – integer, порядковый номер команды из исходного файла (нумерация с 0);
 Выходные параметры: массив из 2х элементов. 0й индекс - сколько 1я команда забила голов 2й команде, 1й индекс - сколько 2я команда забила голов первой команде. Например: function match($c1, $c2){ return array(2, 1); }
3) Счет матча рассчитывается рандомом с заданной вероятностью.
 Вероятность забивания голов определяется мощностью команд (чем сильнее команда, тем выше вероятность, что она забьет больше голов сопернику и ниже вероятность пропуска голов в свои ворота).
 Рандом – ключевой фактор при определении счета. Именно благодаря рандому (случайностям) победа не гарантирована даже самой сильной команде (от игры к игре между теми же командами результаты могут быть разными).
Требования к выполненной работе
 Решением задачи являются файлы программы. В корне должен быть файл index.php с функцией match (описанной в п.2). Файл будет подключаться к системе тестирования, и вызываться функция match.
 Задание выполняется на php (версия php 5.2 – 7.0) без использования фреймворков.

**Инструкция по развертыванию и запуску:**
1. Клонируем репозиторий: git clone https://github.com/argab/football.git
2. Либо можно скачать архив с файлами прямо из github.

Файл для старта программы находится по пути: '~/public/index.php'
