INSERT INTO steps (slug, title, description, detail, official_url, official_url_label, icon, sort_order, applies_to_eu, applies_to_non_eu, requires_working, requires_housing, requires_program, requires_age_max, optional_suggestion) VALUES

-- NON-EU ONLY: MVV + Residence permit (must happen BEFORE arrival)
('residence-permit',
 'Apply for your residence permit (MVV + VVR)',
 'As a non-EU student staying more than 90 days, you need a residence permit. Your university applies to the IND on your behalf. Start this process at least 3 months before you plan to travel.',
 'Your university (as a recognised IND sponsor) submits the combined MVV entry visa and VVR residence permit application to the IND. Once approved, you collect the MVV sticker at a Dutch embassy in your country and travel to the Netherlands. You then collect your residence permit card at an IND desk after arrival. Important: students from Australia, Canada, Japan, Monaco, New Zealand, South Korea, the UK, the USA, and Vatican City do not need an MVV entry visa but still need the VVR residence permit.',
 'https://ind.nl/en/residence-permits/study',
 'IND — Study residence permits',
 'shield-check',
 1,
 0, 1,
 NULL, NULL, NULL, NULL,
 NULL
),

-- NON-EU ONLY: TB test
('tb-test',
 'TB test (tuberculosis screening)',
 'Students from certain countries are required to take a TB test within 3 months of arriving in the Netherlands. Your university will inform you if this applies to you.',
 'The TB test is not taken in your home country — it is done in the Netherlands after arrival at a regional GGD (public health) office. The test costs approximately €60. Your university will notify you if your nationality requires this. The test must be completed within 3 months of your arrival date.',
 'https://www.ggd.nl/',
 'GGD — Find your regional office',
 'clipboard-list',
 2,
 0, 1,
 NULL, NULL, NULL, NULL,
 NULL
),

-- EVERYONE: Register at gemeente — get BSN
('bsn',
 'Register at the municipality (gemeente) — get your BSN',
 'Your BSN (Burgerservicenummer) is your Dutch citizen service number. It is required for almost everything in the Netherlands: bank accounts, health insurance, DigiD, and more. Register within 5 days of arrival.',
 'Visit your local gemeente with a valid passport and proof of address (rental contract or permission letter from your host). EU citizens can choose any of the 19 RNI municipalities. Non-EU citizens must go to the gemeente where they will live, and must already have their residence permit. You receive your BSN on the spot or by post within a few days. Many universities organise group registration days — check with your international office first.',
 'https://www.government.nl/topics/personal-data/citizen-service-number-bsn',
 'Government.nl — BSN information',
 'building-office',
 3,
 1, 1,
 NULL, NULL, NULL, NULL,
 NULL
),

-- EVERYONE: DigiD (requires BSN)
('digid',
 'Create your DigiD account',
 'DigiD is your digital identity for all Dutch government services — tax returns, DUO student finance, healthcare portals, and more. You need your BSN to apply.',
 'Apply for DigiD online at digid.nl. You will receive an activation letter by post within 5 working days. Once activated, you can use DigiD to log in to all Dutch government portals including MijnOverheid, DUO, and the Belastingdienst (tax authority).',
 'https://www.digid.nl/en',
 'DigiD — Apply here',
 'identification',
 4,
 1, 1,
 NULL, NULL, NULL, NULL,
 NULL
),

-- EVERYONE: Bank account (requires BSN)
('bank-account',
 'Open a Dutch bank account',
 'You need a Dutch bank account to receive wages, pay rent, and manage daily expenses. Most banks require your BSN and a Dutch address.',
 'Popular options for international students include ING, ABN AMRO, Rabobank, and Bunq (which can sometimes be opened before arriving). Bring your passport, BSN, and proof of address. Some universities have arrangements with specific banks and organise on-campus bank account days during introduction week.',
 'https://www.studyinnl.org/plan-your-stay/open-a-bank-account',
 'Study in NL — Banking guide',
 'banknotes',
 5,
 1, 1,
 NULL, NULL, NULL, NULL,
 NULL
),

-- EVERYONE: Health insurance (requires BSN; mandatory only if working/internship)
('health-insurance',
 'Arrange health insurance (zorgverzekering)',
 'Dutch health insurance is mandatory if you work or do an internship in the Netherlands. Even if it is not legally required for your situation, having coverage is strongly recommended.',
 'If you work or do an internship, Dutch health insurance (basisverzekering) is legally required within 4 months of starting. If you are a pure study student on an exchange or minor, Dutch insurance is not mandatory — but check whether your home country or university insurance covers you in the Netherlands. Compare Dutch insurers and sign up via their websites. You will need your BSN.',
 'https://www.studyinnl.org/plan-your-stay/healthcare-insurance',
 'Study in NL — Healthcare insurance guide',
 'heart-pulse',
 6,
 1, 1,
 NULL, NULL, NULL, NULL,
 'Even if not legally required for your programme type, consider getting Dutch health insurance or checking that your home country coverage is valid here. Contact the official helpline at skgz.nl/english for advice.'
),

-- EVERYONE: GP registration
('gp',
 'Register with a GP (huisarts)',
 'In the Netherlands you need to register with a local general practitioner (huisarts) to access healthcare. Without a GP you cannot get referrals to specialists or prescriptions.',
 'Find a GP near your address using a GP finder website or by asking your university. Call or visit the practice and ask to register. Bring your BSN and proof of address. Many GP practices near universities have experience with international students. Note: you can register with a GP even without Dutch health insurance.',
 'https://www.skgz.nl/english',
 'SKGZ — Official health insurance helpline',
 'stethoscope',
 7,
 1, 1,
 NULL, NULL, NULL, NULL,
 NULL
),

-- EVERYONE: Student OV card (DUO, requires BSN, age < 30, HBO/Bachelor/MBO)
('ov-card',
 'Get your student OV-chipkaart (public transport card)',
 'The student OV-chipkaart lets you travel free by public transport on weekdays or weekends throughout the Netherlands. It is issued by DUO and linked to your student enrolment.',
 'Apply via the DUO portal (Mijn DUO) using your DigiD. You must be enrolled in a recognised full-time HBO, Bachelor, or MBO programme and be under 30. The card is sent by post. You choose a weekday or weekend subscription. Note: exchange students and minor students are generally not eligible — check with your institution. The student OV card is a benefit loan that must be repaid if you do not graduate within 10 years.',
 'https://duo.nl/particulier/student-finance/',
 'DUO — Student finance and OV card',
 'train',
 8,
 1, 0,
 NULL, NULL, 'bachelor,mbo,hbo', 30,
 'Check your eligibility carefully. Exchange, minor, PhD, and other programme types are generally not eligible. Non-EU students are not eligible for DUO products.'
),

-- CONDITIONAL: Studiefinanciering (EU only, age < 30, specific programmes, working)
('studiefinanciering',
 'Apply for student finance (Studiefinanciering) from DUO',
 'EU students under 30 enrolled in a Bachelor, HBO, or MBO programme may be eligible for Dutch student finance, depending on whether they work in the Netherlands.',
 'EU students (non-Dutch) can apply for DUO student finance if they are under 30, enrolled full-time in an HBO, Bachelor, or MBO programme, and either: have lived in the Netherlands for 5+ consecutive years, or currently work at least 32 hours per month for a Dutch employer. Pure international students who have just arrived will not meet the residency requirement. Apply via Mijn DUO using your DigiD. Non-EU students are not eligible for DUO student finance.',
 'https://duo.nl/particulier/student-finance/eligibility.jsp',
 'DUO — Check your eligibility',
 'academic-cap',
 9,
 1, 0,
 NULL, NULL, 'bachelor,mbo,hbo', 30,
 'Most newly arrived EU students will not immediately qualify because of the 5-year residency requirement. If you work 32h/month for a Dutch employer, check your eligibility with DUO directly.'
),

-- CONDITIONAL: Huurtoeslag (private rental, age < 30, BSN required)
('huurtoeslag',
 'Apply for housing allowance (Huurtoeslag)',
 'If you rent privately and are under 30, you may be eligible for a monthly housing allowance from the Dutch tax authority (Belastingdienst).',
 'Huurtoeslag (rent allowance) is a government benefit that helps cover rental costs for low-income renters. You need a BSN, DigiD, and a private rental contract. Student housing (via the university or a housing corporation) may also qualify — check the criteria. Apply via Mijn Belastingdienst using your DigiD. Your income and rent amount determine how much you receive.',
 'https://www.belastingdienst.nl/wps/wcm/connect/bldcontenten/standaard_functies/individuals/contact/your_rights_and_obligations/filing_a_tax_return/filing_a_tax_return',
 'Belastingdienst — Tax and allowances',
 'home',
 10,
 1, 1,
 NULL, 'private_rental', NULL, 30,
 'Eligibility depends on your rental price, income, and other conditions. Use the online eligibility checker on the Belastingdienst website before applying.'
),

-- CONDITIONAL: Tax return (working students)
('tax-return',
 'File a tax return (Belastingaangifte)',
 'If you work in the Netherlands, you may need to file an annual tax return with the Dutch tax authority. You might also be entitled to a refund.',
 'If you earned income in the Netherlands (part-time job, internship with pay, etc.), you are required to file a tax return by 1 May each year via Mijn Belastingdienst. You need DigiD to log in. Many students receive a partial refund because of the tax credits applied by their employer. Even if you are not required to file, it is often worth doing.',
 'https://www.mijnbelastingdienst.nl/mbd-pmb/registreren',
 'Mijn Belastingdienst — File your return',
 'receipt-refund',
 11,
 1, 1,
 1, NULL, NULL, NULL,
 NULL
);

-- Step dependencies
INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'digid'             AND s2.slug = 'bsn';

INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'bank-account'      AND s2.slug = 'bsn';

INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'health-insurance'  AND s2.slug = 'bsn';

INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'ov-card'           AND s2.slug = 'digid';

INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'studiefinanciering' AND s2.slug = 'digid';

INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'huurtoeslag'       AND s2.slug = 'digid';

INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'tax-return'        AND s2.slug = 'digid';

INSERT INTO step_dependencies (step_id, depends_on_step_id)
SELECT s1.id, s2.id FROM steps s1, steps s2
WHERE s1.slug = 'bsn'              AND s2.slug = 'residence-permit';
