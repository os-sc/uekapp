use umf_db;
INSERT INTO polls (question, answers, answercounts, voters, public, allowmulti, checkdupes, date, creator)
 VALUES ("Was wollen wir essen?","Pizza|Kuchen|Brokkoli|Keckse", "3|5|13|9", "", true, true, true, 1478072518,
0);

INSERT INTO polls (question, answers, answercounts, voters, public, allowmulti, checkdupes, date, creator)
 VALUES ("Was wollen wir trinken?","Soda|Wasser|Brokkolisaft|Cola", "7|9|19|9", "", true, true, false, 1478082518,
0);

INSERT INTO polls (question, answers, answercounts, voters, public, allowmulti, checkdupes, date, creator)
 VALUES ("Wo wollen wir wohnen?","Haus|Wohnung|Brokkolihütte|Villa", "6|0|23|9", "", true, false, true, 1478072918,
0);
