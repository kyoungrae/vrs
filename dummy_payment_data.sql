-- 결제 확인 메뉴 더미 데이터 생성 쿼리
-- 실행 순서: 1) TRANSACTION 2) EPAY_TRANSACTION

-- ============================================
-- 1. TRANSACTION 테이블 더미 데이터 (type=1: 일반결제)
-- ============================================

INSERT INTO "VRS"."TRANSACTION" (
    "ID", "ACCOUNT_NUMBER", "INVOICE_ID", "DESCRIPTION", 
    "RELATED_ACCOUNT", "OWNER_NAME", "AMOUNT", 
    "TRANSACTION_DATE", "TYPE", "ARKHIVE_NO"
) VALUES (
    100001, 123456789, 1, '신규 차량 등록 수수료',
    987654321, '바트툴가', '15000',
    TIMESTAMP '2025-04-15 10:30:00', 1, 'АРХ2025001'
);

INSERT INTO "VRS"."TRANSACTION" (
    "ID", "ACCOUNT_NUMBER", "INVOICE_ID", "DESCRIPTION", 
    "RELATED_ACCOUNT", "OWNER_NAME", "AMOUNT", 
    "TRANSACTION_DATE", "TYPE", "ARKHIVE_NO"
) VALUES (
    100002, 123456790, 2, '번호판 변경 수수료',
    987654322, '강석', '25000',
    TIMESTAMP '2025-04-15 11:15:00', 1, 'АРХ2025002'
);

INSERT INTO "VRS"."TRANSACTION" (
    "ID", "ACCOUNT_NUMBER", "INVOICE_ID", "DESCRIPTION", 
    "RELATED_ACCOUNT", "OWNER_NAME", "AMOUNT", 
    "TRANSACTION_DATE", "TYPE", "ARKHIVE_NO"
) VALUES (
    100003, 123456791, 3, '소유자 변경 수수료',
    987654323, '오윤퉁알라그', '20000',
    TIMESTAMP '2025-04-15 14:20:00', 1, 'АРХ2025003'
);

INSERT INTO "VRS"."TRANSACTION" (
    "ID", "ACCOUNT_NUMBER", "INVOICE_ID", "DESCRIPTION", 
    "RELATED_ACCOUNT", "OWNER_NAME", "AMOUNT", 
    "TRANSACTION_DATE", "TYPE", "ARKHIVE_NO"
) VALUES (
    100004, 123456792, 4, '차량 검사 수수료',
    987654324, '게렐마а', '30000',
    TIMESTAMP '2025-04-15 16:45:00', 1, NULL
);

INSERT INTO "VRS"."TRANSACTION" (
    "ID", "ACCOUNT_NUMBER", "INVOICE_ID", "DESCRIPTION", 
    "RELATED_ACCOUNT", "OWNER_NAME", "AMOUNT", 
    "TRANSACTION_DATE", "TYPE", "ARKHIVE_NO"
) VALUES (
    100005, 123456793, 5, '증명서 재발급',
    987654325, '줄주셈', '5000',
    TIMESTAMP '2025-04-15 09:00:00', 1, 'АРХ2025005'
);

-- ============================================
-- 2. TRANSACTION 테이블 더미 데이터 (type=2: 번호판 보관)
-- ============================================

INSERT INTO "VRS"."TRANSACTION" (
    "ID", "ACCOUNT_NUMBER", "INVOICE_ID", "DESCRIPTION", 
    "RELATED_ACCOUNT", "OWNER_NAME", "AMOUNT", 
    "TRANSACTION_DATE", "TYPE", "ARKHIVE_NO"
) VALUES (
    200001, 223456789, 101, '번호판 보관 수수료',
    887654321, '밧툴가', '10000',
    TIMESTAMP '2025-04-14 13:30:00', 2, 'АРХ2025010'
);

INSERT INTO "VRS"."TRANSACTION" (
    "ID", "ACCOUNT_NUMBER", "INVOICE_ID", "DESCRIPTION", 
    "RELATED_ACCOUNT", "OWNER_NAME", "AMOUNT", 
    "TRANSACTION_DATE", "TYPE", "ARKHIVE_NO"
) VALUES (
    200002, 223456790, 102, '번호판 보관 수수료',
    887654322, '한타이시르', '10000',
    TIMESTAMP '2025-04-14 15:00:00', 2, NULL
);

-- ============================================
-- 3. EPAY_TRANSACTION 테이블 더미 데이터
-- TRANSACTION_ID와 매핑 (TRANSACTION 테이블의 ID 참조)
-- ============================================

-- 주의: 아래 VEHICLE_ID 값은 실제 REG_VEHICLE 테이블에 존재하는 ID로 변경 필요
-- SERVICE_ID 값도 실제 SYSTEM_SERVICE 테이블에 존재하는 ID로 변경 필요

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    900001, 100001, 1, 1,
    'АРХ2025001', TIMESTAMP '2025-04-15 10:30:00', '카드결제', 15000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    900002, 100002, 2, 2,
    'АРХ2025002', TIMESTAMP '2025-04-15 11:15:00', '카드결제', 25000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    900003, 100003, 3, 3,
    'АРХ2025003', TIMESTAMP '2025-04-15 14:20:00', '계좌이체', 20000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    900004, 100004, 4, 4,
    NULL, TIMESTAMP '2025-04-15 16:45:00', '카드결제', 30000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    900005, 100005, 5, 5,
    'АРХ2025005', TIMESTAMP '2025-04-15 09:00:00', '현금', 5000
);

-- ============================================
-- 4. EPAY_TRANSACTION 번호판 보관 데이터
-- ============================================

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    900101, 200001, 10, 101,
    'АРХ2025010', TIMESTAMP '2025-04-14 13:30:00', '카드결제', 10000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    900102, 200002, 11, 101,
    NULL, TIMESTAMP '2025-04-14 15:00:00', '계좌이체', 10000
);

COMMIT;

-- ============================================
-- 검증 쿼리 (데이터 확인용)
-- ============================================

-- 1. 일반 결제 데이터 조회 (payment 메뉴용)
SELECT 
    tr."ID", epay."ID" as epay_id, epay."VEHICLE_ID", 
    tr."ACCOUNT_NUMBER", tr."RELATED_ACCOUNT", tr."DESCRIPTION", 
    tr."AMOUNT", tr."OWNER_NAME", tr."TRANSACTION_DATE", 
    tr."ARKHIVE_NO", epay."ARKHIVE_NO", epay."CREATED_AT",
    epay."PAY_TYPE_NAME", service."NAME"
FROM "VRS"."TRANSACTION" tr 
JOIN "VRS"."EPAY_TRANSACTION" epay ON tr."ID" = epay."TRANSACTION_ID" 
JOIN "VRS"."SYSTEM_SERVICE" service ON service."ID" = epay."SERVICE_ID"
WHERE tr."TYPE" = 1;

-- 2. API용 조회 (ServiceController용)
SELECT 
    tr."ID", epay."ID" as epay_id, epay."VEHICLE_ID", 
    tr."ACCOUNT_NUMBER", tr."RELATED_ACCOUNT", tr."DESCRIPTION", 
    tr."AMOUNT", tr."OWNER_NAME", tr."TRANSACTION_DATE", 
    tr."ARKHIVE_NO", epay."ARKHIVE_NO", epay."CREATED_AT",
    epay."PAY_TYPE_NAME", service."NAME", vehicle."PLATE_NO"
FROM "VRS"."TRANSACTION" tr 
JOIN "VRS"."EPAY_TRANSACTION" epay ON tr."ID" = epay."TRANSACTION_ID" 
JOIN "VRS"."SYSTEM_SERVICE" service ON service."ID" = epay."SERVICE_ID"
JOIN "VRS"."REG_VEHICLE" vehicle ON epay."VEHICLE_ID" = vehicle."ID"
WHERE tr."RELATED_ACCOUNT" IS NOT NULL;

-- 3. 미처리 데이터 조회 (ARKHIVE_NO가 null인 데이터)
SELECT * FROM "VRS"."TRANSACTION" 
WHERE "ARKHIVE_NO" IS NULL AND "RELATED_ACCOUNT" IS NOT NULL;
