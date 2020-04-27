if(!window.calendar_languages) {
	window.calendar_languages = {};
}
window.calendar_languages['ru-RU'] = {
	error_noview:     'Календарь: Шаблон вида {0} не найден.',
	error_dateformat: 'Календарь: неверный формат даты {0}. Должно быть или "now" или "yyyy-mm-dd"',
	error_loadurl:    'Календарь: не назначен URL для загрузки событий.',
	error_where:      'Календарь: неправильная навигация {0}. Можно только "next", "prev" или "today"',
	error_timedevide: 'Календарь: Параметер разделитель времени должен делить 60 на целое число. Например 10, 15, 30',

	title_year:  '{0}',
	title_month: '{0} {1}',
	title_week:  '{0} неделя года {1}',
	title_day:   '{0}, {1} {2} {3}',

	week:        'Неделя {0}',
	all_day:     'Весь день',
	time:        'Время',
	events:      'События',
	before_time: 'Заканчиваются перед временной лентой',
	after_time:  'Заканчиваются после временной ленты',

	m0:  'Январь',
	m1:  'Февраль',
	m2:  'Март',
	m3:  'Апрель',
	m4:  'Май',
	m5:  'Июнь',
	m6:  'Июль',
	m7:  'Август',
	m8:  'Сентябрь',
	m9:  'Октябрь',
	m10: 'Ноябрь',
	m11: 'Декабрь',

	ms0:  'Янв',
	ms1:  'Фев',
	ms2:  'Мар',
	ms3:  'Апр',
	ms4:  'Май',
	ms5:  'Июн',
	ms6:  'Июл',
	ms7:  'Авг',
	ms8:  'Сен',
	ms9:  'Окт',
	ms10: 'Ноя',
	ms11: 'Дек',

	d0: 'Воскресенье',
	d1: 'Понедельник',
	d2: 'Вторник',
	d3: 'Среда',
	d4: 'Четверг',
	d5: 'Пятница',
	d6: 'Суббота',

	easter:       'Пасха',
	easterMonday: 'Пасхальный понедельник',

	first_day: 1,

	holidays: {
		'01-01':       'Новый год',
		'02-01>06-01': 'Новогодние каникулы',
		'07-01':       'Рождество Христово',
		'08-01':       'Новогодние каникулы',
		'23-02':       'День защитника Отечества',
		'08-03':       'Международный женский день',
		'01-05':       'Праздник Весны и Труда',
		'09-05':       'День Победы',
		'12-06':       'День России',
		'04-11':       'День народного единства'
	}
};
