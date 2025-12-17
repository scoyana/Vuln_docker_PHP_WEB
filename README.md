<div align="center">

# 📘 My PHP Bulletin Board Project  
**A lightweight PHP & MySQL board built for learning web development and web security.**

![Static Badge](https://img.shields.io/badge/PHP-7.4%2B-8892BF?logo=php)
![Static Badge](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)
![Static Badge](https://img.shields.io/badge/Apache-2.x-D22128?logo=apache)
![Static Badge](https://img.shields.io/badge/License-MIT-green)
![Static Badge](https://img.shields.io/badge/Status-Active-brightgreen)

</div>

---

## 🚀 **프로젝트 개요**
이 프로젝트는 **LAMP 스택 기반의 기본 CRUD 게시판**을 직접 만드는 실습용 프로젝트입니다.  
웹 개발의 전체 흐름을 경험하고, 나아가 웹 해킹(Pentesting) 실습 환경으로도 사용할 수 있도록 설계되었습니다.

---

## 📂 **기능 요약**

### 📝 게시판 기능
- 게시글 목록 조회  
- 게시글 검색  
- 게시글 작성 / 수정 / 삭제  
- 첨부파일 업로드 및 다운로드  

### 👤 회원 기능
- 회원가입  
- 로그인 / 로그아웃  
- 세션 기반 사용자 인증  
- 작성자 검증 후 글 수정/삭제 가능  

> ⚠️ **이 프로젝트는 학습용이며, 실서비스 수준의 보안 처리가 되어 있지 않습니다.**

---

## 🧱 **사용 기술**
| Category | Stack |
|---------|-------|
| Backend | PHP 7.4+ |
| Database | MySQL / MariaDB |
| Web Server | Apache 2.x |
| Frontend | HTML / CSS |
| OS | Ubuntu / WSL / Docker |

---

🔧 환경 변수 설정 (.env)

프로젝트를 실행하기 전에 루트 디렉토리에 .env 파일을 생성해야 합니다.

프로젝트에는 .env_sample 파일이 포함되어 있으므로, 이를 복사하여 사용하세요.

cp .env_sample .env


그리고 .env 파일 안의 값을 자신의 환경에 맞게 설정합니다.

예시:

DB_HOST=mysql
DB_USER=root
DB_PASS=your_password
DB_NAME=board
UPLOAD_DIR=/var/www/html/uploads


.env 파일은 민감한 정보를 포함하므로 GitHub에 업로드하면 안 됩니다.
이미 .gitignore에 포함되어 있어 안전합니다.

## 📂 Project Directory Structure

```bash
My_PHP_WEB/
├── .env_sample              # 환경 변수 샘플 파일
├── .gitignore
├── Dockerfile               # PHP + Apache 환경 구성
├── docker-compose.yaml      # 서비스 묶음 실행 설정

├── apache2/                 # Apache 서버 설정
│   ├── apache2.conf
│   └── conf-available/
│       └── security.conf

└── php/                     # 웹 애플리케이션 메인 코드
    ├── index.php            # 게시글 목록 / 메인 페이지
    ├── home.php             
    ├── view.php             # 게시글 상세보기
    ├── write.php            # 글 작성 페이지
    ├── write_ok.php         # 글 작성 처리
    ├── edit.php             # 글 수정 페이지
    ├── edit_ok.php          # 글 수정 처리
    ├── delete.php           # 글 삭제 처리

    ├── post_list.php        # 게시글 출력 전용 include 파일
    ├── pagination.php       # 페이징 처리

    ├── login.php            # 로그인 UI
    ├── login_ok.php         # 로그인 처리
    ├── logout.php
    ├── register.php         # 회원가입 페이지
    ├── register_ok.php
    ├── account.php          # 내 정보 페이지
    ├── change_password.php
    ├── delete_account.php
    ├── check_user.php       # AJAX 중복 체크 등 검증
    ├── search.php           # 검색 페이지

    ├── layout.php           # 공통 레이아웃
    ├── header.php
    ├── footer.php

    ├── db.php               # DB 연결 파일

    ├── css/
    │   └── style.css        # 스타일 시트

    ├── js/
    │   └── check_id.js      # 아이디 중복 검사 JS

    ├── img/
    │   └── download.png

    └── uploads/             # 업로드된 파일 저장소