
CREATE TABLE den (
    id_den   NUMBER NOT NULL,
    nazev    VARCHAR2(15) NOT NULL
);

ALTER TABLE den ADD CONSTRAINT den_pk PRIMARY KEY ( id_den );

CREATE TABLE fakulta (
    id_fakulty        NUMBER NOT NULL,
    nazev_fakulty     VARCHAR2(50) NOT NULL,
    zkratka_fakulty   VARCHAR2(5) NOT NULL
);


ALTER TABLE fakulta ADD CONSTRAINT fakulta_pk PRIMARY KEY ( id_fakulty );


CREATE TABLE forma_vyuky (
    id_forma      NUMBER NOT NULL,
    nazev_formy   VARCHAR2(15) NOT NULL
);

ALTER TABLE forma_vyuky ADD CONSTRAINT forma_vyuky_pk PRIMARY KEY ( id_forma );

CREATE TABLE katedra (
    id_katedry           NUMBER NOT NULL,
    nazev_katedry        VARCHAR2(50) NOT NULL,
    zkratka_katedry      VARCHAR2(5) NOT NULL,
    fakulta_id_fakulty   NUMBER NOT NULL
);

ALTER TABLE katedra ADD CONSTRAINT katedra_pk PRIMARY KEY ( id_katedry );


CREATE TABLE kategorie (
    id_kategorie      NUMBER NOT NULL,
    nazev_kategorie   VARCHAR2(1) NOT NULL
);

ALTER TABLE kategorie ADD CONSTRAINT kategorie_pk PRIMARY KEY ( id_kategorie );

CREATE TABLE tab_obraz (
    id_obraz               NUMBER NOT NULL,
    typ                    VARCHAR2(50) NOT NULL,
    pripona                VARCHAR2(50) NOT NULL,
    datum_pridani          DATE NOT NULL,
    obsah                  BLOB NOT NULL,
    uzivatel_id_uzivatel   NUMBER NOT NULL
);

ALTER TABLE tab_obraz ADD CONSTRAINT tab_obraz_pk PRIMARY KEY ( id_obraz );

CREATE TABLE mistnost (
    id_mistnosti         NUMBER NOT NULL,
    kapacita_mistnosti   NUMBER NOT NULL,
    oznaceni             VARCHAR2(10) NOT NULL
);



ALTER TABLE mistnost ADD CONSTRAINT mistnost_pk PRIMARY KEY ( id_mistnosti );


CREATE TABLE predmet (
    id_predmety                     NUMBER NOT NULL,
    nazev_predmetu                  VARCHAR2(50) NOT NULL,    
    zkratka_predmetu			VARCHAR2(20) NOT NULL,
    semestr					VARCHAR2(20) NOT NULL,
    zpusob_zak_id   NUMBER NOT NULL
);

ALTER TABLE predmet ADD CONSTRAINT predmet_pk PRIMARY KEY ( id_predmety );




CREATE TABLE predmet_v_planu (
    id_prob                   NUMBER NOT NULL,    
    rocnik                    NUMBER NOT NULL,
    predmet_id_predmety       NUMBER NOT NULL,
    kategorie_id    NUMBER NOT NULL,
    stud_plan_id   NUMBER NOT NULL
);

ALTER TABLE predmet_v_planu ADD CONSTRAINT predmet_v_planu_pk PRIMARY KEY ( id_prob );


CREATE TABLE role_admin (
    id_role   NUMBER NOT NULL,
    nazev     VARCHAR2(15) NOT NULL
);

ALTER TABLE role_admin ADD CONSTRAINT role_admin_pk PRIMARY KEY ( id_role );

CREATE TABLE role_uceni (
    id_role_uc   NUMBER NOT NULL,
    nazev        VARCHAR2(60) NOT NULL
);

ALTER TABLE role_uceni ADD CONSTRAINT role_uceni_pk PRIMARY KEY ( id_role_uc );

CREATE TABLE rozvrhova_aktivita (
    mistnost_id_mistnosti     NUMBER NOT NULL,
    id_aktivity               NUMBER NOT NULL,
    tyden_id                     NUMBER NOT NULL,
    od                        NUMBER NOT NULL,
    do                        NUMBER NOT NULL,
    schvaleno                 NUMBER NOT NULL,
    den_id_den                NUMBER NOT NULL,
    kapacita_akce			NUMBER NOT NULL,
    zpusob_Vyuky_Id		NUMBER NOT NULL,
    uci_Id				NUMBER NOT NULL,
    predmet_planu_id   NUMBER NOT NULL
);

ALTER TABLE rozvrhova_aktivita ADD CONSTRAINT rozvrhova_aktivita_pk PRIMARY KEY ( id_aktivity );

ALTER TABLE rozvrhova_aktivita ADD CONSTRAINT od_check CHECK ( od BETWEEN 6 AND 19 );

ALTER TABLE rozvrhova_aktivita ADD CONSTRAINT do_check CHECK ( do BETWEEN 7 AND 20 );



CREATE TABLE stud_plan (
    stud_obor_id   NUMBER NOT NULL,
    id_stud_planu                 NUMBER NOT NULL,
    rok					NUMBER NOT NULL,
    jmeno_planu                   VARCHAR2(20) NOT NULL
);

ALTER TABLE stud_plan ADD CONSTRAINT stud_plan_pk PRIMARY KEY ( id_stud_planu );



CREATE TABLE studijni_obor (
    id_stud_oboru    NUMBER NOT NULL,
    odhad_studentu   NUMBER NOT NULL,
    jmeno_oboru      VARCHAR2(100) NOT NULL,
    forma_Id NUMBER NOT NULL;
);

ALTER TABLE studijni_obor ADD CONSTRAINT studijni_obor_pk PRIMARY KEY ( id_stud_oboru );

CREATE TABLE tyden(
	id_Tyden		NUMBER NOT NULL,
	nazev_Tyden		VARCHAR2(25) NOT NULL
);
ALTER TABLE tyden ADD CONSTRAINT tyden_pk PRIMARY KEY ( id_tyden );

CREATE TABLE uci (
    id_uci                    NUMBER NOT NULL,
    pocet_hodin            NUMBER NOT NULL,
    role_uceni_id     NUMBER NOT NULL,
    vyucujici_id    NUMBER NOT NULL,
    predmet_planu_id   NUMBER NOT NULL
);

ALTER TABLE uci ADD CONSTRAINT uci_pk PRIMARY KEY ( id_uci );






CREATE TABLE uzivatel (
    id_uzivatel          NUMBER NOT NULL,
    username             VARCHAR2(50) NOT NULL UNIQUE,
    password             VARCHAR2(50) NOT NULL,
    role_id   NUMBER NOT NULL,
    vyucujici_id NUMBER
);



ALTER TABLE uzivatel ADD CONSTRAINT uzivatel_pk PRIMARY KEY ( id_uzivatel );

--ALTER TABLE uzivatel ADD CONSTRAINT usr_constr UNIQUE (username);



CREATE TABLE vyucujici (
    id_vyucujici           NUMBER NOT NULL,
    jmeno                  VARCHAR2(15) NOT NULL,
    prijmeni               VARCHAR2(20) NOT NULL,
    email                  VARCHAR2(50) NOT NULL,
    telefon                VARCHAR2(9) NOT NULL,
    katedra_id_katedry     NUMBER NOT NULL
);




ALTER TABLE vyucujici ADD CONSTRAINT vyucujici_pk PRIMARY KEY ( id_vyucujici );

CREATE TABLE zpusob_vyuky (
    id_zpusob_vyuky   NUMBER NOT NULL,
    nazev_zpusobu     VARCHAR2(20) NOT NULL
);

ALTER TABLE zpusob_vyuky ADD CONSTRAINT zpusob_vyuky_pk PRIMARY KEY ( id_zpusob_vyuky );

CREATE TABLE zpusob_zakonceni (
    id_zakonceni      NUMBER NOT NULL,
    nazev_zakonceni   VARCHAR2(20) NOT NULL
);

ALTER TABLE zpusob_zakonceni ADD CONSTRAINT zpusob_zakonceni_pk PRIMARY KEY ( id_zakonceni );

ALTER TABLE katedra
    ADD CONSTRAINT katedra_fakulta_fk FOREIGN KEY ( fakulta_id_fakulty )
        REFERENCES fakulta ( id_fakulty );



ALTER TABLE predmet_v_planu
    ADD CONSTRAINT predmet_kategorie_fk FOREIGN KEY ( kategorie_id )
        REFERENCES kategorie ( id_kategorie );

ALTER TABLE predmet_v_planu
    ADD CONSTRAINT predmet_stud_plan_fk FOREIGN KEY ( stud_plan_id )
        REFERENCES stud_plan ( id_stud_planu );

ALTER TABLE predmet_v_planu
    ADD CONSTRAINT predmet_v_planu_predmet_fk FOREIGN KEY ( predmet_id_predmety )
        REFERENCES predmet ( id_predmety );

ALTER TABLE predmet
    ADD CONSTRAINT predmet_zpusob_zakonceni_fk FOREIGN KEY ( zpusob_zak_id )
        REFERENCES zpusob_zakonceni ( id_zakonceni );

ALTER TABLE rozvrhova_aktivita
    ADD CONSTRAINT rozvrhova_aktivita_den_fk FOREIGN KEY ( den_id_den )
        REFERENCES den ( id_den );

ALTER TABLE rozvrhova_aktivita
    ADD CONSTRAINT rozvrhova_aktivita_mistnost_fk FOREIGN KEY ( mistnost_id_mistnosti )
        REFERENCES mistnost ( id_mistnosti );

ALTER TABLE rozvrhova_aktivita
    ADD CONSTRAINT rozvrhova_aktivita_predmet_fk FOREIGN KEY ( predmet_planu_id )
        REFERENCES predmet_v_planu ( id_prob );



ALTER TABLE rozvrhova_aktivita
    ADD CONSTRAINT rozvrhova_ak_uci_fk FOREIGN KEY ( Uci_id )
        REFERENCES UCI ( id_Uci );

ALTER TABLE rozvrhova_aktivita
    ADD CONSTRAINT rozvrhova_ak_zpusob_fk FOREIGN KEY ( zpusob_Vyuky_Id )
        REFERENCES Zpusob_Vyuky ( id_Zpusob_Vyuky );

ALTER TABLE studijni_obor
    ADD CONSTRAINT stud_obor_forma_fk FOREIGN KEY ( forma_Id )
        REFERENCES Forma_Vyuky ( id_forma );

ALTER TABLE stud_plan
    ADD CONSTRAINT stud_plan_studijni_obor_fk FOREIGN KEY ( stud_obor_id )
        REFERENCES studijni_obor ( id_stud_oboru );

ALTER TABLE uci
    ADD CONSTRAINT uci_predmet_v_planu_fk FOREIGN KEY ( predmet_planu_id )
        REFERENCES predmet_v_planu ( id_prob );

ALTER TABLE uci
    ADD CONSTRAINT uci_role_uceni_fk FOREIGN KEY ( role_uceni_id )
        REFERENCES role_uceni ( id_role_uc );

ALTER TABLE uci
    ADD CONSTRAINT uci_vyucujici_fk FOREIGN KEY ( vyucujici_id )
        REFERENCES vyucujici ( id_vyucujici );

ALTER TABLE uzivatel
    ADD CONSTRAINT uzivatel_role_admin_fk FOREIGN KEY ( role_id )
        REFERENCES role_admin ( id_role );

ALTER TABLE uzivatel
    ADD CONSTRAINT uzivatel_vyucujici_fk FOREIGN KEY ( vyucujici_id_vyucujici )
        REFERENCES vyucujici ( id_vyucujici );

ALTER TABLE vyucujici
    ADD CONSTRAINT vyucujici_katedra_fk FOREIGN KEY ( katedra_id_katedry )
        REFERENCES katedra ( id_katedry );



ALTER TABLE tab_obraz
    ADD CONSTRAINT tab_obraz_uzivatel_fk FOREIGN KEY ( uzivatel_id_uzivatel )
        REFERENCES uzivatel ( id_uzivatel );

--SEQUENCE AND TRIGGER

CREATE SEQUENCE katedra_seq START WITH 1;
CREATE OR REPLACE TRIGGER katedra_trigg
BEFORE INSERT ON katedra
FOR EACH ROW

BEGIN
  SELECT katedra_seq.NEXTVAL
  INTO   :new.id_katedry
  FROM   dual;
END;

CREATE SEQUENCE fakulta_seq START WITH 1;
CREATE OR REPLACE TRIGGER fakulta_trigg
BEFORE INSERT ON fakulta
FOR EACH ROW

BEGIN
  SELECT fakulta_seq.NEXTVAL
  INTO   :new.id_fakulty
  FROM   dual;
END;


CREATE SEQUENCE mistnost_seq START WITH 1;

CREATE OR REPLACE TRIGGER mistnost_trigg
BEFORE INSERT ON mistnost
FOR EACH ROW

BEGIN
  SELECT mistnost_seq.NEXTVAL
  INTO   :new.id_mistnosti
  FROM   dual;
END;

CREATE SEQUENCE predmet_seq START WITH 1;
CREATE OR REPLACE TRIGGER predmet_trigg
BEFORE INSERT ON predmet
FOR EACH ROW

BEGIN
  SELECT predmet_seq.NEXTVAL
  INTO   :new.id_predmety
  FROM   dual;
END;


CREATE SEQUENCE predmet_plan_seq START WITH 1;
CREATE OR REPLACE TRIGGER predmet_plan_trigg
BEFORE INSERT ON predmet_v_planu
FOR EACH ROW

BEGIN
  SELECT predmet_plan_seq.NEXTVAL
  INTO   :new.id_prob
  FROM   dual;
END;

CREATE SEQUENCE rozvrh_seq START WITH 1;
CREATE OR REPLACE TRIGGER rozvrh_trigg
BEFORE INSERT ON rozvrhova_aktivita
FOR EACH ROW

BEGIN
  SELECT rozvrh_seq.NEXTVAL
  INTO   :new.id_aktivity
  FROM   dual;
END;

CREATE SEQUENCE plan_seq START WITH 1;
CREATE OR REPLACE TRIGGER plan_trigg
BEFORE INSERT ON stud_plan
FOR EACH ROW

BEGIN
  SELECT plan_seq.NEXTVAL
  INTO   :new.id_stud_planu
  FROM   dual;
END;

CREATE SEQUENCE obor_seq START WITH 1;
CREATE OR REPLACE TRIGGER obor_trigg
BEFORE INSERT ON studijni_obor
FOR EACH ROW

BEGIN
  SELECT obor_seq.NEXTVAL
  INTO   :new.id_stud_oboru
  FROM   dual;
END;

CREATE SEQUENCE uci_seq START WITH 1;
CREATE OR REPLACE TRIGGER uci_trigg
BEFORE INSERT ON uci
FOR EACH ROW

BEGIN
  SELECT uci_seq.NEXTVAL
  INTO   :new.id_uci
  FROM   dual;
END;




CREATE OR REPLACE SEQUENCE uzivatel_seq START WITH 1;
create or replace TRIGGER uzivatel_trigg
BEFORE INSERT ON uzivatel
FOR EACH ROW

BEGIN
  SELECT uzivatel_seq.NEXTVAL
  INTO   :new.id_uzivatel
  FROM   dual;
END;

CREATE OR REPLACE SEQUENCE vyucujici_seq START WITH 1;
create or replace TRIGGER vyucujici_trigg
BEFORE INSERT ON vyucujici
FOR EACH ROW

BEGIN
  SELECT vyucujici_seq.NEXTVAL
  INTO   :new.id_vyucujici
  FROM   dual;
END;


--VIEWS 
create or replace view view_ucitel_uci as select uc.pocet_hodin, vyuc.jmeno, vyuc.prijmeni, vyuc.id_vyucujici, pla.rok,pla.id_stud_planu, pred.id_prob, ru.id_role_uc, ru.nazev from Vyucujici vyuc, Uci uc, Stud_Plan pla, Predmet_v_Planu pred,Role_uceni ru where pla.id_stud_planu = pred.stud_plan_id and vyuc.id_vyucujici = uc.vyucujici_id and ru.id_role_uc = uc.role_uceni_id ;
create or replace view uzivatel_ucitel2 as select *  from Uzivatel uzi, Vyucujici vyuc, Role_Admin hra where uzi.role_id = hra.id_role and 
uzi.vyucujici_id = vyuc.id_vyucujici;

create or replace view view_ucitel_uci2 as select * from Vyucujici vyuc, Uci uc, Stud_Plan pla, Predmet_v_Planu pred,Role_uceni ru, Katedra kat, Fakulta fak where uc.predmet_planu_id = pred.id_prob and fak.id_fakulty = kat.fakulta_id_fakulty and kat.id_katedry = vyuc.katedra_id_katedry and pla.id_stud_planu = pred.stud_plan_id and vyuc.id_vyucujici = uc.vyucujici_id and ru.id_role_uc = uc.role_uceni_id ;

create or replace view uzivatel_ucitel as select ro.nazev as privilegium, uz.username, vyuc.jmeno, vyuc.prijmeni from 
Uzivatel uz,Vyucujici vyuc, Role_admin ro where uz.role_id = ro.id_role
and uz.vyucujici_id = vyuc.id_vyucujici;

create or replace view uzivatel_ucitel2 as select *  from Uzivatel uzi, Vyucujici vyuc, Role_Admin hra where uzi.role_id = hra.id_role and 
uzi.vyucujici_id = vyuc.id_vyucujici;

create or replace view uzivatel_role as select * from uzivatel uzi, role_admin rol where uzi.role_id = rol.id_role;

create or replace view view_obor as select ob.id_stud_oboru, ob.odhad_studentu, ob.jmeno_oboru, forma.nazev_formy from studijni_obor ob, forma_vyuky forma where ob.forma_id = forma.id_forma;

create or replace view view_rozvrhova_akce2 as select uc.id_uci,ra.id_aktivity, ra.od, ra.do, ra.schvaleno, ra.kapacita_akce,pvp.id_prob,vyuc.id_vyucujici,mi.id_mistnosti,
mi.oznaceni, de.nazev, ty.nazev_tyden,zv.nazev_zpusobu, pred.nazev_predmetu, vyuc.jmeno, vyuc.prijmeni, pred.id_predmety, pl.rok, pl.id_stud_planu
from Rozvrhova_aktivita ra, Mistnost mi, Den de, Tyden ty, Zpusob_vyuky zv, Uci uc, Vyucujici vyuc, Predmet pred, Predmet_v_planu pvp, Stud_plan pl where 
ra.mistnost_id_mistnosti = mi.id_mistnosti and ra.den_id_den = de.id_den and ra.zpusob_vyuky_id = zv.id_zpusob_vyuky and ra.tyden_id = ty.id_tyden
and uc.vyucujici_id = vyuc.id_vyucujici and ra.uci_id = uc.id_uci and pvp.predmet_id_predmety = pred.id_predmety and pvp.stud_plan_id = pl.id_stud_planu
and pvp.id_prob = ra.predmet_planu_id;

create or replace view view_uc_kat_fak as select * from Vyucujici vyuc, Katedra kat, Fakulta fak where
kat.fakulta_id_fakulty = fak.id_fakulty and vyuc.katedra_id_katedry = kat.id_katedry;


create or replace view  view_predmety_uplny as select pvp.id_prob,pvp.rocnik, pred.nazev_predmetu, pred.zkratka_predmetu, pred.semestr, zz.nazev_zakonceni,ktg.nazev_kategorie,pl.jmeno_planu,pl.rok,pl.id_stud_planu,pl.stud_obor_id from Predmet pred, Predmet_v_Planu pvp, Zpusob_zakonceni zz, Kategorie ktg, Stud_plan pl where pl.id_stud_planu = pvp.stud_plan_id and pred.zpusob_zak_id = zz.id_zakonceni and pvp.kategorie_id = ktg.id_kategorie and pred.id_predmety = pvp.predmet_id_predmety;

create or replace view  view_predmety_uplny2 as select pvp.id_prob,pvp.rocnik,pred.id_predmety, pred.nazev_predmetu, pred.zkratka_predmetu, pred.semestr, zz.nazev_zakonceni,ktg.nazev_kategorie,pl.jmeno_planu,pl.rok,pl.id_stud_planu,pl.stud_obor_id from Predmet pred, Predmet_v_Planu pvp, Zpusob_zakonceni zz, Kategorie ktg, Stud_plan pl where pl.id_stud_planu = pvp.stud_plan_id and pred.zpusob_zak_id = zz.id_zakonceni and pvp.kategorie_id = ktg.id_kategorie and pred.id_predmety = pvp.predmet_id_predmety;


create or replace view view_obor_plan as select * from Studijni_obor so, Stud_Plan sp, Forma_vyuky fv where so.id_stud_oboru = sp.stud_obor_id and fv.id_forma = so.forma_id;



create or replace view db_pracoviste as select f.id_fakulty, f.nazev_fakulty, f.zkratka_fakulty, k.id_katedry, k.nazev_katedry, k.zkratka_katedry from 
katedra k, fakulta f where f.id_fakulty = k.fakulta_id_fakulty;

CREATE OR REPLACE view ucitel_katedra AS 
  select vyuc.id_vyucujici, vyuc.jmeno,vyuc.prijmeni,vyuc.email,vyuc.telefon,kat.zkratka_katedry
from Vyucujici vyuc, Katedra kat where kat.id_katedry = vyuc.katedra_id_katedry;

CREATE OR REPLACE VIEW view_predmety AS 
  select pr.zkratka_predmetu,pr.nazev_predmetu, pr.id_predmety,pv.id_prob,pv.stud_plan_id from Predmet pr, Predmet_v_planu pv where pv.predmet_id_predmety = pr.id_predmety;

--FUNCTIONS

create or replace function func_delete_vlozi(ucitel_id NUMBER, pred_plan NUMBER)
return varchar is var_message varchar2(200);
    var_exists NUMBER;
    var_id_uci NUMBER;
begin
    select id_uci into var_id_uci from uci where vyucujici_id = ucitel_id and predmet_planu_id = pred_plan;
    select count(*) into var_exists from rozvrhova_aktivita where uci_id = var_id_uci;
    if var_exists > 0 then
        var_message:= 'Tento ucitel ma rozvrhové akce. Doopravy jej chcete vyjmout z predmetu?';
        return var_message;
    end if;
    delete from UCI where vyucujici_id = ucitel_id and predmet_planu_id = pred_plan;    
    var_message := 'SUCCESS';
    return var_message;
    
exception 
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;



create or replace function func_update_plan(id_planu Number, studo Number, jmeno Varchar2, rokk Number) return varchar is var_message Varchar2(250);
 var_duplicity NUMBER;
 --var_ok boolean;
begin
    DBMS_OUTPUT.PUT_LINE('LINE 1');
    select count(*) into var_duplicity from stud_plan where jmeno_planu = jmeno and rokk = rok;
    if var_duplicity > 0 then
    DBMS_OUTPUT.PUT_LINE('LINE 2');
        var_message := 'Takovýto studijní plán už existuje. Akce neproveditelná.';
        return var_message;
    end if;
DBMS_OUTPUT.PUT_LINE('LINE 3');
    select count(*) into var_duplicity from predmet_v_planu where stud_plan_id = id_planu;
    if var_duplicity = 0 then
        var_message := 'SUCCESS';
        update stud_plan set stud_obor_id = studo, jmeno_planu = jmeno,rok = rokk where id_stud_planu = id_planu;
        return var_message;
    end if;
    if verify_integrity_uci(rokk, id_planu) = false then
        var_message := 'Zmena plánu narušuje ucební hodiny nekterých kantoru. Akce neproveditelná.';
        return var_message;
    end if;
    if verify_integrity_rozvrh1(rokk,id_planu) = false then
        var_message:= 'Zmena plánu narušuje rozvrh. Akce neproveditelná.';
        return var_message;
    end if;
    update stud_plan set stud_obor_id = studo, jmeno_planu = jmeno,rok = rokk where id_stud_planu = id_planu;
    var_message := 'SUCCESS';
    return var_message;
    
exception 
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;


create or replace function func_update_pvp(id_pvp NUMBER,zkratka Varchar2,zpusob Varchar2,kateg Varchar2, plan_id Number, roc Number) return varchar is var_message varchar2(250);
var_duplicita Number;
    var_id_pr Number;
    var_id_kat Number;
    var_p_count Number;
    var_children1 NUMBER;
    var_children2 NUMBER;
    var_rok NUMBER;
begin
DBMS_OUTPUT.PUT_LINE('LINE 1');
 select id_predmety into var_id_pr from view_predmety_uplny2 where id_prob = id_pvp;
 DBMS_OUTPUT.PUT_LINE('LINE 2');
    select count(*) into var_duplicita from view_predmety_uplny2 where var_id_pr = id_predmety and plan_id = id_stud_planu and id_pvp != id_prob;
    if var_duplicita > 0  then
    DBMS_OUTPUT.PUT_LINE('LINE 3');
        var_message := 'Tento predmet se jiz v planu nachazi. Nelze jej vlozit znovu';
        return var_message;
    end if;
    DBMS_OUTPUT.PUT_LINE('LINE 4');
    select count(*) into var_children1 from uci where id_pvp = predmet_planu_id;
    select count(*) into var_children2 from rozvrhova_aktivita where id_pvp = predmet_planu_id;
    DBMS_OUTPUT.PUT_LINE('LINE 5');
     select id_kategorie into var_id_kat from kategorie where nazev_kategorie = kateg;
   
    if var_children1 = 0 and var_children2 = 0 then
DBMS_OUTPUT.PUT_LINE('LINE 6');
        update Predmet_v_planu set rocnik = roc, predmet_id_predmety = var_id_pr, kategorie_id = var_id_kat, stud_plan_id = plan_id where id_prob = id_pvp; 
        var_message:= 'SUCCESS';
        return var_message;
    end if;
    select rok into var_rok from stud_plan where id_stud_planu = plan_id;
    if verify_integrity_uci(var_rok, plan_id) = false then
        var_message := 'Zmena predmetu narušuje ucební hodiny nekterých kantoru. Akce neproveditelná.';
        return var_message;
    end if;
    if verify_integrity_rozvrh1(var_rok,plan_id) = false then
        var_message:= 'Zmena predmetu narušuje rozvrh. Akce neproveditelná.';
        return var_message;
    end if;
     update Predmet_v_planu set rocnik = roc, predmet_id_predmety = var_id_pr, kategorie_id = var_id_kat, stud_plan_id = plan_id where id_prob = id_pvp; 
     var_message:= 'SUCCESS';
     return var_message;
     
    
exception 
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;

end;









create or replace function func_update_rozvrh(id_ak NUMBER,kapac NUMBER, misto NUMBER, tydenn VARCHAR2, od_cas NUMBER, do_cas NUMBER, zpusob VARCHAR2, denn VARCHAR2, ucitel_id NUMBER, predmet_id NUMBER, rokk NUMBER, schval NUMBER )

return varchar is 
var_message varchar2(200);
    var_id NUMBER;
    var_duplicita NUMBER;
    var_id_uci NUMBER;
    var_id_mistnosti NUMBER;
    var_id_tyden NUMBER;
    var_id_den NUMBER;
    var_zpus_vyuky NUMBER;
    var_hodiny_test NUMBER;
    var_hodiny_uci NUMBER;
    var_tyden_kolize NUMBER;
    var_id_plan NUMBER;
    var_id_obor NUMBER;
    var_celkovy_pocet NUMBER;
    var_odhad_pocet NUMBER;
     var_kap_mist NUMBER;
    var_schopnost_uci NUMBER;
    CHECK_CONSTRAINT_VIOLATED EXCEPTION;
    PRAGMA EXCEPTION_INIT(CHECK_CONSTRAINT_VIOLATED, -2290);
begin 

select id_uci into var_id_uci from uci where predmet_planu_id = predmet_id and vyucujici_id = ucitel_id;
select id_zpusob_vyuky into var_zpus_vyuky from zpusob_vyuky where nazev_zpusobu = zpusob;
--select id_mistnosti into var_id_mistnosti from mistnost where oznaceni = misto;
select id_den into var_id_den from den where nazev = denn;
select id_tyden into var_id_tyden from tyden where nazev_tyden = tydenn;
select pocet_hodin into var_hodiny_uci from uci where id_uci = var_id_uci;
select kapacita_mistnosti into var_kap_mist from mistnost where id_mistnosti = misto;
select role_uceni_id into var_schopnost_uci from uci where id_uci = var_id_uci;



if (var_schopnost_uci = 1 and var_zpus_vyuky = 3) or (var_schopnost_uci = 2 and var_zpus_vyuky !=3) then
 var_message := 'Tento vyucující nemuže vyucovat takovou akci';
 return var_message;
 end if;

if kapac > var_kap_mist then
    var_message := 'Vybraná Místnost má moc malou kapacitu';
    return var_message;
    end if;
--select count(*) into var_duplicita from view_rozvrhova_akce2 where id_mistnosti = var_id_mistnosti and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba'); 
select count(*) into var_duplicita from view_rozvrhova_akce2 where id_mistnosti = misto and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba') and id_aktivity!= id_ak  and nazev = denn; 



if var_duplicita > 0 then
    var_message := 'Místnost je zabraná';
    return var_message;
end if;



select NVL(sum(do-od),0) into var_hodiny_test from rozvrhova_aktivita where uci_id = var_id_uci and id_aktivity!= id_ak;
if (var_hodiny_test +(do_cas-od_cas)) > var_hodiny_uci then --kontroluje jestli vyucující nemá moc hodin
    var_message:= 'Ucitel ucí príliš mnoho hodin';
    return var_message;
    end if;

select count(*) into var_duplicita from view_rozvrhova_akce2 where id_vyucujici = ucitel_id and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba') and id_aktivity!= id_ak and nazev = denn;  
if var_duplicita > 0 then
    var_message:= 'Akce se uciteli kryje s jinou akcí v tomto roce';
    return var_message;
end if;

select stud_plan_id into var_id_plan from predmet_v_planu where id_prob = predmet_id;
select stud_obor_id into var_id_obor from stud_plan where id_stud_planu = var_id_plan;
select odhad_studentu into var_odhad_pocet from studijni_obor where id_stud_oboru = var_id_obor;
select NVL(sum(kapacita_akce),0) into var_celkovy_pocet from view_rozvrhova_akce2 where id_prob = predmet_id and nazev_zpusobu = zpusob and id_aktivity!= id_ak;
if var_celkovy_pocet > var_odhad_pocet then
    var_message := 'Akce je zbytecná, ostatní akce již pokrývají všechny studenty';
    return var_message;
end if;
update  Rozvrhova_aktivita set mistnost_id_mistnosti = misto, tyden_id = var_id_tyden, 
od = od_cas, do = do_cas, schvaleno = schval, den_id_den = var_id_den, predmet_planu_id = predmet_id, kapacita_akce = kapac,
uci_id = var_id_uci, zpusob_vyuky_id = var_zpus_vyuky where id_aktivity = id_ak; 
var_message:='SUCCESS';
return var_message;
EXCEPTION
  WHEN CHECK_CONSTRAINT_VIOLATED THEN 
    var_message:= 'Tento cas spadá mimo dobu výuky';
    return var_message;
    
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;





create or replace function func_update_user(id_usr NUMBER,jmeno varchar2,pass Varchar2, rol Varchar2, ucitel_id NUMBER ) return VARCHAR is var_message VARCHAR2(250);
var_duplicity NUMBER;
var_what NUMBER;
var_id NUMBER;
begin
var_what := ucitel_id;
    if ucitel_id = 0 then
        var_what := null;
        
    end if;
 

  --  select count(*) into var_duplicity from uzivatel where (username = jmeno ) --and id_uzivatel != id_usr;
  --  if var_duplicity > 0 then
   --     var_message := 'Chybný záznam, uživatelské jméno už existuje';
    --    return  var_message;
   -- end if;
   --   select count(*) into var_duplicity from uzivatel where ( ucitel_id = --vyucujici_id) and id_uzivatel != id_usr;
  --  if var_duplicity > 0 then
    --     var_message := 'Chybný záznam, snažíte se navázat moc ucitelu';
     --   return  var_message;
   -- end if;

    select id_role into var_id from role_admin where nazev = rol;
  
    
    update uzivatel set username = jmeno,"PASSWORD" = pass,role_id = var_id,vyucujici_id = var_what where id_uzivatel = id_usr;
var_message := 'SUCCESS';

    return var_message;
    exception 
      WHEN DUP_VAL_ON_INDEX THEN
        var_message :='Chybný záznam, uživatelské jméno už existuje';
        return var_message;
 when others then 
 
    var_message := 'Jiná necekaná chyba';
    return var_message;
   
end;

create or replace function func_uprav_rozvrh_admin(id_ak NUMBER, kapac NUMBER, misto NUMBER, tydenn VARCHAR2, od_cas NUMBER, do_cas NUMBER, zpusob VARCHAR2, denn VARCHAR2, ucitel_id NUMBER, predmet_id NUMBER, rokk NUMBER, schval NUMBER )
--WORK IN PROGRESS
return varchar is 
var_message varchar2(200);
    var_id NUMBER;
    var_duplicita NUMBER;
    var_id_uci NUMBER;
    var_id_mistnosti NUMBER;
    var_id_tyden NUMBER;
    var_id_den NUMBER;
    var_zpus_vyuky NUMBER;
    var_hodiny_test NUMBER;
    var_hodiny_uci NUMBER;
    var_tyden_kolize NUMBER;
    CHECK_CONSTRAINT_VIOLATED EXCEPTION;
  PRAGMA EXCEPTION_INIT(CHECK_CONSTRAINT_VIOLATED, -2290);

begin 

select id_uci into var_id_uci from uci where predmet_planu_id = predmet_id and vyucujici_id = ucitel_id;
select id_zpusob_vyuky into var_zpus_vyuky from zpusob_vyuky where nazev_zpusobu = zpusob;
--select id_mistnosti into var_id_mistnosti from mistnost where oznaceni = misto;
select id_den into var_id_den from den where nazev = denn;
select id_tyden into var_id_tyden from tyden where nazev_tyden = tydenn;
select pocet_hodin into var_hodiny_uci from uci where id_uci = var_id_uci;

select count(*) into var_duplicita from view_rozvrhova_akce2 where id_mistnosti = misto and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba')  and nazev = denn and id_ak != id_aktivity; 



if var_duplicita > 0 then
    var_message := 'Místnost je zabraná';
    return var_message;
end if;

update  Rozvrhova_aktivita set mistnost_id_mistnosti = misto, tyden_id = var_id_tyden, 
od = od_cas, do = do_cas, schvaleno = schval, den_id_den = var_id_den, predmet_planu_id = predmet_id, kapacita_akce = kapac,
uci_id = var_id_uci, zpusob_vyuky_id = var_zpus_vyuky where id_aktivity = id_ak; 
var_message:='SUCCESS';
return var_message;
EXCEPTION
  WHEN CHECK_CONSTRAINT_VIOLATED THEN 
    var_message:= 'Tento cas spadá mimo dobu výuky';
    return var_message;
    
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;

create or replace function func_vloz_pvp(zkratka Varchar2,zpusob Varchar2,kateg Varchar2, plann Varchar2, plan_id Number, roc Number)
return varchar is var_message VARCHAR2(200);
    var_duplicita Number;
    var_id_pr Number;
    var_id_kat Number;
    var_p_count Number;
begin
    select count(*) into var_duplicita from view_predmety_uplny where zkratka = zkratka_predmetu and plan_id = id_stud_planu;
    if var_duplicita > 0 then
        var_message := 'Tento predmet se jiz v planu nachazi. Nelze jej vlozit znovu';
        return var_message;
    end if;
    select id_kategorie into var_id_kat from kategorie where nazev_kategorie = kateg;
    select id_predmety into var_id_pr from predmet where zkratka_predmetu = zkratka;
    insert into Predmet_v_planu(rocnik, predmet_id_predmety, kategorie_id, stud_plan_id)values(roc, var_id_pr, var_id_kat,plan_id);

    var_message := 'SUCCESS';
return var_message;
    
exception 
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;



create or replace function func_vloz_pvp2(zkratka Varchar2,zpusob Varchar2,kateg Varchar2, plan_id Number, roc Number)
return varchar is var_message VARCHAR2(200);
    var_duplicita Number;
    --THIS ONE IS SUPERIOR, USE IT
    var_id_pr Number;
    var_id_kat Number;
begin
    select count(*) into var_duplicita from view_predmety_uplny where zkratka = zkratka_predmetu and  plan_id = id_stud_planu;
    if var_duplicita > 0 then
        var_message := 'Tento predmet se jiz v planu nachazi. Nelze jej vlozit znovu';
        return var_message;
    end if;
    select id_kategorie into var_id_kat from kategorie where nazev_kategorie = kateg;
    select id_predmety into var_id_pr from predmet where zkratka_predmetu = zkratka;
    insert into Predmet_v_planu(rocnik, predmet_id_predmety, kategorie_id, stud_plan_id)values(roc, var_id_pr, var_id_kat,plan_id);

    var_message := 'SUCCESS';
return var_message;

exception 
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;





create or replace function func_vloz_uci(ucitel_id NUMBER, pred_plan NUMBER, rolle Varchar2, hodiny NUMBER)-- rolle Varchar2, rokk NUMBER,hodin NUMBER)
return varchar is 
var_message varchar2(200);
    var_hours Number;
    var_duplicity NUMBER;
    var_rolle_id NUMBER;
    var_rolle_duplicity NUMBER;
begin
    select NVL(SUM(Pocet_hodin),0) into var_hours from view_ucitel_uci where id_vyucujici = ucitel_id and pred_plan = id_prob;
    --NVL(var_hours,0);
    var_hours := var_hours + hodiny;
     --select COUNT(*) into var_duplicity from view_ucitel_uci where id_vyucujici = ucitel_id and rok = rokk;
    if var_hours > 40 then
        var_message := 'Tento ucitel uz v tomto roce uci ' || var_hours || ' hodin z maxima 40';
        return var_message;
    --elseif 
    end if;
    select COUNT(*) into var_duplicity from view_ucitel_uci where id_vyucujici = ucitel_id and pred_plan = id_prob;
    if var_duplicity > 0 then
        var_message := 'Tento ucitel uz tento predmet v tomto roce uci';
        return var_message;
    end if;
    select COUNT(*) into var_rolle_duplicity from view_ucitel_uci where pred_plan = id_prob and nazev = 'Garant';
    if var_rolle_duplicity > 1 then
        var_message := 'Predmet nemuze mit dva garanty';
        return var_message;
    end if;
    select id_role_uc into var_rolle_id from role_uceni where nazev = rolle;
    insert into UCI (pocet_hodin, role_uceni_id,vyucujici_id, predmet_planu_id)values(hodiny, var_rolle_id, ucitel_id, pred_plan);
    var_message := 'SUCCESS';    
    return var_message;
    

exception 
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;




create or replace function func_vloz_user(jmeno varchar2,pass Varchar2, rol Varchar2, ucitel_id NUMBER ) return NUMBER is var_new_id NUMBER;
var_duplicity NUMBER;
var_what NUMBER;
var_id NUMBER;
begin


var_what := ucitel_id;
    if ucitel_id = 0 then
        var_what := null;
    end if;

   -- select count(*) into var_duplicity from uzivatel where username = jmeno;-- or ucitel_id = vyucujici_id;
    --if var_duplicity > 0 then
      --  var_new_id := -1;
        --return var_new_id;
    --end if;
    select id_role into var_id from role_admin where nazev = rol;
    insert into uzivatel(username,"PASSWORD",role_id,vyucujici_id)values (jmeno,pass,var_id,var_what);

    SELECT id_uzivatel
    into var_new_id
     FROM uzivatel
    WHERE username = jmeno;
    return var_new_id;
EXCEPTION
    WHEN DUP_VAL_ON_INDEX THEN
        var_new_id := -1;
        return var_new_id;
       
   
end;


create or replace function verify_integrity_rozvrh1(rokk NUMBER, plan_id NUMBER) return boolean is truth boolean;
var_duplicity NUMBER;
begin
FOR aktivita IN (SELECT * FROM view_rozvrhova_akce2 where id_stud_planu = plan_id)
  LOOP
  DBMS_OUTPUT.PUT_LINE('verigy_ingegrity_rozvrh first test');
    select count(*) into var_duplicity from view_rozvrhova_akce2 where ((aktivita.id_vyucujici = id_vyucujici and rok = rokk)
    and aktivita.id_aktivity != id_aktivity) and ((aktivita.od between od and do) or (aktivita.do between od and do));
    DBMS_OUTPUT.PUT_LINE('verigy_ingegrity_rozvrh second test: ' || var_duplicity);
    if var_duplicity >0 then
        truth := false;
        return truth;
    end if;
  END LOOP;
  truth:=true;
  DBMS_OUTPUT.PUT_LINE('verigy_ingegrity_rozvrh final test: ');
  return truth;
end;

create or replace function verify_integrity_uci(rokk NUMBER, plan_id NUMBER) return boolean is truth boolean;
var_sum NUMBER;
BEGIN
  FOR ucitel IN (SELECT id_vyucujici FROM view_ucitel_uci)
  LOOP
    select NVL(sum(pocet_hodin),0) into var_sum from view_ucitel_uci where id_vyucujici = ucitel.id_vyucujici and (rok = rokk or plan_id = id_stud_planu);
     DBMS_OUTPUT.PUT_LINE('verigy_ingegrity_uci first test ' || var_sum);
    if var_sum >40 then
        truth := false;
        return truth;
    end if;
  END LOOP;
  truth:= true;
  DBMS_OUTPUT.PUT_LINE('verigy_ingegrity_uci final test ');
  return truth;
END;


create or replace function func_vloz_rozvrh(kapac NUMBER, misto NUMBER, tydenn VARCHAR2, od_cas NUMBER, do_cas NUMBER, zpusob VARCHAR2, denn VARCHAR2, ucitel_id NUMBER, predmet_id NUMBER, rokk NUMBER, schval NUMBER )
--WORK IN PROGRESS
return varchar is 
var_message varchar2(200);
    var_id NUMBER;
    var_duplicita NUMBER;
    var_id_uci NUMBER;
    var_id_mistnosti NUMBER;
    var_id_tyden NUMBER;
    var_id_den NUMBER;
    var_zpus_vyuky NUMBER;
    var_hodiny_test NUMBER;
    var_hodiny_uci NUMBER;
    var_tyden_kolize NUMBER;
    var_id_plan NUMBER;
    var_id_obor NUMBER;
    var_celkovy_pocet NUMBER;
    var_odhad_pocet NUMBER;
    var_kap_mist NUMBER;
    var_schopnost_uci NUMBER;
    var_denni_opak NUMBER;
    CHECK_CONSTRAINT_VIOLATED EXCEPTION;
  PRAGMA EXCEPTION_INIT(CHECK_CONSTRAINT_VIOLATED, -2290);
begin 

select id_uci into var_id_uci from uci where predmet_planu_id = predmet_id and vyucujici_id = ucitel_id;
select id_zpusob_vyuky into var_zpus_vyuky from zpusob_vyuky where nazev_zpusobu = zpusob;
--select id_mistnosti into var_id_mistnosti from mistnost where oznaceni = misto;
select id_den into var_id_den from den where nazev = denn;
select id_tyden into var_id_tyden from tyden where nazev_tyden = tydenn;
select pocet_hodin into var_hodiny_uci from uci where id_uci = var_id_uci;
--select kapacita_mistnosti into var_kap_mist from mistnost where id_mistnosti = var_id_mistnosti;1
select kapacita_mistnosti into var_kap_mist from mistnost where id_mistnosti = misto;
select role_uceni_id into var_schopnost_uci from uci where id_uci = var_id_uci;
if (var_schopnost_uci = 1 and var_zpus_vyuky = 3) or (var_schopnost_uci = 2 and var_zpus_vyuky !=3) then
 var_message := 'Tento vyucující nemuže vyucovat takovou akci';
 return var_message;
 end if;

if kapac > var_kap_mist then
    var_message := 'Vybraná Místnost má moc malou kapacitu';
    return var_message;
    end if;
--select count(*) into var_duplicita from view_rozvrhova_akce2 where id_mistnosti = var_id_mistnosti and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba'); 
select count(*) into var_duplicita from view_rozvrhova_akce2 where id_mistnosti = misto and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba')  and nazev = denn; 



if var_duplicita > 0 then
    var_message := 'Místnost je zabraná';
    return var_message;
end if;
select NVL(sum(do-od),0) into var_hodiny_test from rozvrhova_aktivita where uci_id = var_id_uci;
if (var_hodiny_test +(do_cas-od_cas)) > var_hodiny_uci then --kontroluje jestli vyucující nemá moc hodin
    var_message:= 'Ucitel ucí príliš mnoho hodin';
    return var_message;
    end if;
 
select count(*) into var_duplicita from view_rozvrhova_akce2 where id_vyucujici = ucitel_id and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba') and nazev = denn;  
if var_duplicita > 0 then
    var_message:= 'Akce se uciteli kryje s jinou akcí v tomto roce';
    return var_message;
end if;

select stud_plan_id into var_id_plan from predmet_v_planu where id_prob = predmet_id;
select stud_obor_id into var_id_obor from stud_plan where id_stud_planu = var_id_plan;
select odhad_studentu into var_odhad_pocet from studijni_obor where id_stud_oboru = var_id_obor;
select NVL(sum(kapacita_akce),0) into var_celkovy_pocet from view_rozvrhova_akce2 where id_prob = predmet_id and nazev_zpusobu = zpusob;
if var_celkovy_pocet > var_odhad_pocet then
    var_message := 'Akce je zbytecná, ostatní akce již pokrývají všechny studenty';
    return var_message;
end if;
insert into Rozvrhova_aktivita(mistnost_id_mistnosti, tyden_id, od, do, schvaleno, den_id_den, predmet_planu_id, kapacita_akce, uci_id, zpusob_vyuky_id)
values(misto, var_id_tyden, od_cas, do_cas, schval,var_id_den, predmet_id, kapac, var_id_uci,var_zpus_vyuky); 
var_message:='SUCCESS';
return var_message;
EXCEPTION
  WHEN CHECK_CONSTRAINT_VIOLATED THEN 
    var_message:= 'Tento cas spadá mimo dobu výuky';
    return var_message;
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
end;





create or replace function func_vloz_rozvrh_admin(kapac NUMBER, misto NUMBER, tydenn VARCHAR2, od_cas NUMBER, do_cas NUMBER, zpusob VARCHAR2, denn VARCHAR2, ucitel_id NUMBER, predmet_id NUMBER, rokk NUMBER )
--WORK IN PROGRESS
return varchar is 
var_message varchar2(200);
    var_id NUMBER;
    var_duplicita NUMBER;
    var_id_uci NUMBER;
    var_id_mistnosti NUMBER;
    var_id_tyden NUMBER;
    var_id_den NUMBER;
    var_zpus_vyuky NUMBER;
    var_hodiny_test NUMBER;
    var_hodiny_uci NUMBER;
    var_tyden_kolize NUMBER;
    CHECK_CONSTRAINT_VIOLATED EXCEPTION;
  PRAGMA EXCEPTION_INIT(CHECK_CONSTRAINT_VIOLATED, -2290);
    
begin 

select id_uci into var_id_uci from uci where predmet_planu_id = predmet_id and vyucujici_id = ucitel_id;
select id_zpusob_vyuky into var_zpus_vyuky from zpusob_vyuky where nazev_zpusobu = zpusob;
--select id_mistnosti into var_id_mistnosti from mistnost where oznaceni = misto;
select id_den into var_id_den from den where nazev = denn;
select id_tyden into var_id_tyden from tyden where nazev_tyden = tydenn;
select pocet_hodin into var_hodiny_uci from uci where id_uci = var_id_uci;

select count(*) into var_duplicita from view_rozvrhova_akce2 where id_mistnosti = misto and ((od_cas between od and do) or (do_cas between od and do)) and  rok = rokk and (nazev_tyden = tydenn or nazev_tyden = 'Oba')  and nazev = denn; 



if var_duplicita > 0 then
    var_message := 'Místnost je zabraná';
    return var_message;
end if;

insert into Rozvrhova_aktivita(mistnost_id_mistnosti, tyden_id, od, do, schvaleno, den_id_den, predmet_planu_id, kapacita_akce, uci_id, zpusob_vyuky_id)
values(misto, var_id_tyden, od_cas, do_cas, 0,var_id_den, predmet_id, kapac, var_id_uci,var_zpus_vyuky); 
var_message:='SUCCESS';
return var_message;
EXCEPTION
  WHEN CHECK_CONSTRAINT_VIOLATED THEN 
    var_message:= 'Tento cas spadá mimo dobu výuky';
    return var_message;
    when others then 
    var_message := 'Jiná necekaná chyba';
    return var_message;
     
end;



--DELETE TRIGGERS
create or replace trigger trigg_delet_uci before delete on Vyucujici for each row
begin
    delete from Uci where vyucujici_id = :old.id_vyucujici;
end;

create or replace trigger trigg_delet_uziv before delete on Vyucujici for each row
begin
    delete from Uci where vyucujici_id = :old.id_vyucujici;
end;



create or replace trigger trigg_delet_rozvrh before delete on Uci for each row
begin
    delete from Rozvrhova_aktivita where uci_id = :old.id_uci;
end;

create or replace trigger trigg_delet_rozvrh2 before delete on Predmet_v_Planu for each row
begin
    delete from Rozvrhova_aktivita where predmet_planu_id = :old.id_prob;
end;


create or replace trigger trigg_delet_pvp before delete on Predmet for each row
begin
    delete from Predmet_v_planu where predmet_id_predmety = :old.id_predmety;
end;

create or replace trigger trigg_delet_pvp2 before delete on Stud_plan for each row
begin
    delete from Predmet_v_planu where stud_plan_id = :old.id_stud_planu;
end;

create or replace trigger trigg_delet_plan before delete on Studijni_obor for each row
begin
    delete from stud_plan where stud_obor_id = :old.id_stud_oboru;
end;

create or replace trigger trigg_delet_user before delete on Vyucujici for each row
begin
    delete from Uzivatel where vyucujici_id = :old.id_vyucujici;
end;

create or replace trigger trigg_delet_katedra before delete on Fakulta for each row
begin
    delete from Katedra where fakulta_id_fakulty = :old.id_fakulty;
end;

create or replace trigger trigg_delet_vyuc before delete on Katedra for each row
begin
delete from Vyucujici where katedra_id_katedry = :old.id_katedry;
end;

create or replace trigger trigg_delet_ra before delete on Mistnost for each row
begin
delete from Rozvrhova_aktivita where mistnost_id_mistnosti = :old.id_mistnosti;
end;


--PROCEDURES

create or replace procedure proc_delete_predmet(id_pred NUMBER) as
    
    var_id2 number;
    var_count number;
begin

    select predmet_id_predmety into var_id2 from predmet_v_planu where id_prob = id_pred; 
    select count(*) into var_count from predmet_v_planu where predmet_id_predmety = var_id2;
    if var_count = 1 then
        delete from predmet where id_predmety = var_id2;
   end if;
    delete from predmet_v_planu where id_prob = id_pred;
end;

create or replace procedure proc_delete_vlozi2(ucitel_id NUMBER, pred_plan NUMBER)
is
    var_id NUMBER;
begin
     select id_uci into var_id from uci where vyucujici_id = ucitel_id and predmet_planu_id = pred_plan;
     delete from Rozvrhova_aktivita where uci_id = var_id;
     delete from Uci where id_uci = var_id;
end;


create or replace procedure proc_update_obor(ob_id NUMBER,odhad NUMBER, jmeno VARCHAR2, fo VARCHAR2)
is
    var_id NUMBER;
    var_count Number;
begin
    select id_forma into var_id from forma_vyuky where nazev_formy = fo;
    select count (*) into var_count from studijni_obor where jmeno = jmeno_oboru and forma_id = var_id;    
    if var_count = 0 then
        UPDATE Studijni_Obor
        SeT Odhad_Studentu = odhad, Jmeno_Oboru = jmeno, forma_id = var_id
        WHERE id_stud_oboru = ob_id;
        end if;
end;



create or replace procedure proc_update_predmet(id_pred NUMBER, nazev Varchar2, zkratka Varchar2, semester Varchar2, zpus Varchar2) as
    var_id number;
    var_id2 number;
    var_duplicity number;
begin
    select predmet_id_predmety into var_id2 from predmet_v_planu where id_prob = id_pred; 
    select count(*) into var_duplicity from predmet where zkratka_predmetu = zkratka and var_id2 != id_predmety ;
    select id_zakonceni into var_id from zpusob_zakonceni where nazev_zakonceni = zpus;
    if var_duplicity < 1 then
    DBMS_OUTPUT.PUT_LINE('updated');
--maybe check for semestr fallout
     update predmet set nazev_predmetu = nazev, zpusob_zak_id = var_id,zkratka_predmetu= zkratka, semestr = semester where id_predmety = var_id2;
        commit;
       
    end if;
end;


create or replace procedure proc_vloz_obor(odhad NUMBER, jmeno VARCHAR2, fo VARCHAR2)
is
    var_id NUMBER;
    var_count Number;
begin
    select id_forma into var_id from forma_vyuky where nazev_formy = fo;
    --DBMS_OUTPUT.Put_Line(fo);
    select count (*) into var_count from studijni_obor where jmeno = jmeno_oboru and forma_id = var_id;
    --DBMS_OUTPUT.Put_Line(var_count);
if var_count = 0 then
   -- DBMS_OUTPUT.Put_Line('made it here');
    INSERT INTO studijni_obor(odhad_studentu, jmeno_oboru, forma_id) VALUES (odhad, jmeno, var_id);
    end if;
end;



create or replace procedure proc_vloz_predmet(nazev Varchar2, zkratka Varchar2, semester Varchar2, zpus Varchar2) as
    var_id number;
    var_duplicity number;
begin
    select count(*) into var_duplicity from predmet where zkratka_predmetu = zkratka;
    select id_zakonceni into var_id from zpusob_zakonceni where nazev_zakonceni = zpus;
    if var_duplicity = 0 then


        insert into predmet (nazev_predmetu, zpusob_zak_id,zkratka_predmetu, semestr) values (nazev, var_id, zkratka, semester);
        commit;
    end if;
end;

