<style>
    .info_period {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .list-base ul {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px 20px;
        padding: 0;
        list-style-type: none;
    }

    .list-base li {
        font-weight: bold;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 10px;
    }

    .list-base li span {
        font-weight: normal;
        text-decoration: underline;
    }

    .separation-line {
        margin: 20px auto;
        height: 2px;
        background-color: #ccc;
        width: 60%;
    }
</style>
<div>
    <div class="info_period">Данные в отчете представлены за отчетный период: </div>
    <div class="list-base">
        <ul>
            <li>Количество сделок: <span>123</span></li>
            <li>Средний чек сделки: <span>15 000 ₽</span></li>
            <li>Общий объем продаж: <span>1 500 000 ₽</span></li>
            <li>Конверсия из лида в сделку: <span>25%</span></li>
            <li>Средний срок сделки: <span>14 дней</span></li>
            <li>Сделки в работе: <span>30</span></li>
        </ul>
    </div>
    <div class="separation-line"></div>
</div>


