-- ============================================
-- 확인된 결제 내역 (Confirmed Payment) 더미 데이터
-- /report/ePay/users 메뉴용
-- ============================================

-- EPAY_TRANSACTION 테이블에 더 많은 결제 데이터 추가
-- 주의: created_by, service_id, pay_type 값은 실제 테이블 ID로 조정 필요

-- ============================================
-- 1. 카드결제 데이터 (pay_type = 1)
-- TRANSACTION_ID는 dummy_payment_data.sql의 TRANSACTION.ID와 일치해야 함
-- 100001, 100002, 100003, 100004, 100005 사용
-- ============================================

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910001, 100001, 101, 1,
    1, 'АРХ2025101', TIMESTAMP '2025-04-15 09:30:00', 1, '카드결제', 15000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910002, 100002, 102, 2,
    1, 'АРХ2025102', TIMESTAMP '2025-04-15 10:15:00', 1, '카드결제', 25000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910003, 100003, 103, 1,
    1, 'АРХ2025103', TIMESTAMP '2025-04-15 11:45:00', 1, '카드결제', 15000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910004, 100004, 104, 3,
    1, 'АРХ2025104', TIMESTAMP '2025-04-15 14:20:00', 1, '카드결제', 20000
);

-- ============================================
-- 2. 지방결제 데이터 (pay_type = 2)
-- TRANSACTION_ID는 dummy_payment_data.sql의 TRANSACTION.ID와 일치해야 함
-- 200001, 200002 사용
-- ============================================

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    920001, 200001, 201, 1,
    2, 'АРХ2025201', TIMESTAMP '2025-04-15 08:00:00', 2, '지방결제', 15000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    920002, 200002, 202, 2,
    2, 'АРХ2025202', TIMESTAMP '2025-04-15 09:30:00', 2, '지방결제', 25000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    920003, 100001, 203, 4,
    2, 'АРХ2025203', TIMESTAMP '2025-04-15 13:00:00', 2, '지방결제', 30000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    920004, 100002, 204, 1,
    2, 'АРХ2025204', TIMESTAMP '2025-04-15 15:45:00', 2, '지방결제', 15000
);

-- ============================================
-- 3. 다른 날짜 데이터 (일별 통계용)
-- TRANSACTION_ID는 dummy_payment_data.sql의 TRANSACTION.ID와 일치해야 함
-- ============================================

-- 4월 14일 데이터 (TRANSACTION 200001, 200002 사용)
INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910005, 200001, 105, 2,
    1, 'АРХ2025105', TIMESTAMP '2025-04-14 10:00:00', 1, '카드결제', 25000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    920005, 200002, 205, 3,
    2, 'АРХ2025205', TIMESTAMP '2025-04-14 11:30:00', 2, '지방결제', 20000
);

-- 4월 13일 데이터 (TRANSACTION 100001, 100002 사용)
INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910006, 100001, 106, 1,
    1, 'АРХ2025106', TIMESTAMP '2025-04-13 09:15:00', 1, '카드결제', 15000
);

INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    920006, 100002, 206, 2,
    2, 'АРХ2025206', TIMESTAMP '2025-04-13 14:00:00', 2, '지방결제', 25000
);

-- ============================================
-- 4. 다양한 서비스 유형 데이터
-- TRANSACTION_ID는 dummy_payment_data.sql의 TRANSACTION.ID와 일치해야 함
-- 100003, 100004, 100005 사용
-- ============================================

-- 신규등록 (서비스 ID 1) - 추가 데이터
INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910007, 100003, 107, 1,
    1, 'АРХ2025107', TIMESTAMP '2025-04-15 16:00:00', 1, '카드결제', 15000
);

-- 번호판변경 (서비스 ID 2) - 추가 데이터
INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910008, 100004, 108, 2,
    1, 'АРХ2025108', TIMESTAMP '2025-04-15 16:30:00', 1, '카드결제', 25000
);

-- 소유자변경 (서비스 ID 3) - 추가 데이터
INSERT INTO "VRS"."EPAY_TRANSACTION" (
    "ID", "TRANSACTION_ID", "VEHICLE_ID", "SERVICE_ID",
    "CREATED_BY", "ARKHIVE_NO", "CREATED_AT", "PAY_TYPE", "PAY_TYPE_NAME", "AMOUNT"
) VALUES (
    910009, 100005, 109, 3,
    1, 'АРХ2025109', TIMESTAMP '2025-04-15 17:00:00', 1, '카드결제', 20000
);

COMMIT;

-- ============================================
-- 검증 쿼리 (/report/ePay/users 메뉴용)
-- ============================================

-- 1. 사용자별 일별 결제 통계 (카드결제 pay_type=1)
SELECT 
    etr."CREATED_BY",
    usr."LASTNAME", usr."FIRSTNAME",
    service."NAME" as servicename,
    service."ID" as serviceid,
    COUNT(service."ID") as servicecount,
    etr."PAY_TYPE_NAME",
    SUM(etr."AMOUNT") as amount,
    TO_CHAR(etr."CREATED_AT", 'YYYY-MM-DD') as created_at
FROM "VRS"."EPAY_TRANSACTION" etr
JOIN "VRS"."SYSTEM_SERVICE" service ON etr."SERVICE_ID" = service."ID"
JOIN "VRS"."SYSTEM_USER" usr ON etr."CREATED_BY" = usr."ID"
WHERE etr."PAY_TYPE" = 1
  AND etr."CREATED_AT" BETWEEN TO_DATE('2025-04-13', 'yyyy-mm-dd') AND TO_DATE('2025-04-15', 'yyyy-mm-dd')
  AND etr."CREATED_BY" = 1
GROUP BY etr."CREATED_BY", service."ID", service."NAME", usr."LASTNAME", usr."FIRSTNAME",
         TO_CHAR(etr."CREATED_AT", 'YYYY-MM-DD'), etr."PAY_TYPE_NAME"
ORDER BY created_at DESC;

-- 2. 사용자별 일별 결제 통계 (지방결제 pay_type=2)
SELECT 
    etr."CREATED_BY",
    usr."LASTNAME", usr."FIRSTNAME",
    service."NAME" as servicename,
    service."ID" as serviceid,
    COUNT(service."ID") as servicecount,
    etr."PAY_TYPE_NAME",
    SUM(etr."AMOUNT") as amount,
    TO_CHAR(etr."CREATED_AT", 'YYYY-MM-DD') as created_at
FROM "VRS"."EPAY_TRANSACTION" etr
JOIN "VRS"."SYSTEM_SERVICE" service ON etr."SERVICE_ID" = service."ID"
JOIN "VRS"."SYSTEM_USER" usr ON etr."CREATED_BY" = usr."ID"
WHERE etr."PAY_TYPE" = 2
  AND etr."CREATED_AT" BETWEEN TO_DATE('2025-04-13', 'yyyy-mm-dd') AND TO_DATE('2025-04-15', 'yyyy-mm-dd')
  AND etr."CREATED_BY" = 2
GROUP BY etr."CREATED_BY", service."ID", service."NAME", usr."LASTNAME", usr."FIRSTNAME",
         TO_CHAR(etr."CREATED_AT", 'YYYY-MM-DD'), etr."PAY_TYPE_NAME"
ORDER BY created_at DESC;

-- 3. 전체 결제 내역 확인
SELECT 
    etr."ID",
    etr."TRANSACTION_ID",
    etr."VEHICLE_ID",
    etr."SERVICE_ID",
    etr."CREATED_BY",
    etr."ARKHIVE_NO",
    etr."CREATED_AT",
    etr."PAY_TYPE",
    etr."PAY_TYPE_NAME",
    etr."AMOUNT"
FROM "VRS"."EPAY_TRANSACTION" etr
ORDER BY etr."CREATED_AT" DESC;

-- 4. 일별 총액 통계
SELECT 
    TO_CHAR("CREATED_AT", 'YYYY-MM-DD') as day,
    "PAY_TYPE_NAME",
    COUNT(*) as count,
    SUM("AMOUNT") as total_amount
FROM "VRS"."EPAY_TRANSACTION"
GROUP BY TO_CHAR("CREATED_AT", 'YYYY-MM-DD'), "PAY_TYPE_NAME"
ORDER BY day DESC;
