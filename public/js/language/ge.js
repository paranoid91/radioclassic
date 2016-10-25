//! moment.js locale configuration
//! locale : Georgian (ge)
//! author : Salikh Gurgenidze : https://github.com/vatia13

    (function (factory) {
        factory(moment);
    }(function (moment) {

        var ge = moment.defineLocale('ge', {
            months : 'იანვარი_თებერვალი_მარტი_აპრილი_მაისი_ივნისი_ივლისი_აგვისტო_სექტემბერი_ოქტომბერი_ნოემბერი_დეკემბერი'.split('_'),
            monthsShort : 'იან_თებ_მარ_აპრ_მაი_ივნ_ივლ_აგვ_სექ_ოქტ_ნოე_დეკ'.split('_'),
            weekdays : 'კვირა_ორშაბათი_სამშაბათი_ოთხშაბათი_ხუთშაბათი_პარასკევი_შაბათი'.split('_'),
            weekdaysShort : 'კვრ_ორშ_სამ_ოთხ_ხუთ_პარ_შაბ'.split('_'),
            weekdaysMin : 'კვ_ორ_სმ_ოთ_ხთ_პრ_შბ'.split('_'),
            longDateFormat : {
                LT : 'HH:mm',
                LTS : 'HH:mm:ss',
                L : 'DD/MM/YYYY',
                LL : 'D MMMM YYYY',
                LLL : 'D MMMM YYYY LT',
                LLLL : 'dddd, D MMMM YYYY LT'
            },
            calendar : {
                sameDay : '[დღეს] LT',
                nextDay : '[ხვალ] LT',
                nextWeek : 'dddd LT [ზე]',
                lastDay : '[გუშინ] LT [ზე]',
                lastWeek : '[ბოლოს] dddd LT [ზე]',
                sameElse : 'L'
            },
            relativeTime : {
                future : '%s ში',
                past : '%s წინ',
                s : 'რამდენიმე წამი',
                m : 'წუთი',
                mm : '%d წუთი',
                h : 'საათი',
                hh : '%d საათი',
                d : 'დღე',
                dd : '%d დღე',
                M : 'a თვე',
                MM : '%d თვე',
                y : 'a წელი',
                yy : '%d წელი'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal : '%d.',
            week : {
                dow : 1, // ორშაბათი კვირის პირველი დღეა.
                doy : 7  // The week that contains Jan 4th is the first week of the year.
            }
        });

        return ge;

    }));