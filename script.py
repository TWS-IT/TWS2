import time
import mysql.connector
import gspread
from oauth2client.service_account import ServiceAccountCredentials
from datetime import date, datetime
from decimal import Decimal

GOOGLE_SHEET_URL = "https://docs.google.com/spreadsheets/d/1G-s3GszVARWes6JnL4ayLz46yPp_VWhlq-UxqCNoWW0/edit?gid=0#gid=0"
CREDENTIALS_FILE = r"C:\xampp\htdocs\TWS\credentials.json"

DB_CONFIG = {
    "host": "localhost",
    "user": "root",
    "password": "123456",
    "database": "tws"
}

SCOPE = ["https://spreadsheets.google.com/feeds", "https://www.googleapis.com/auth/drive"]
CREDS = ServiceAccountCredentials.from_json_keyfile_name(CREDENTIALS_FILE, SCOPE)
CLIENT = gspread.authorize(CREDS)

def serialize_cell(cell):
    if isinstance(cell, (datetime, date)):
        return cell.strftime("%Y-%m-%d %H:%M:%S") if isinstance(cell, datetime) else cell.strftime("%Y-%m-%d")
    if isinstance(cell, Decimal):
        return float(cell)
    if cell is None:
        return ""
    return str(cell)

def fetch_mysql_data():
    conn = mysql.connector.connect(**DB_CONFIG)
    cursor = conn.cursor()
    cursor.execute("SHOW TABLES")
    tables = cursor.fetchall()
    db_data = {}
    for (table_name,) in tables:
        cursor.execute(f"SELECT * FROM `{table_name}`")
        rows = cursor.fetchall()
        headers = [i[0] for i in cursor.description]
        serialized_rows = [[serialize_cell(c) for c in r] for r in rows]
        db_data[table_name] = [headers] + serialized_rows
    cursor.close()
    conn.close()
    return db_data

def update_google_sheets():
    db_data = fetch_mysql_data()
    spreadsheet = CLIENT.open_by_url(GOOGLE_SHEET_URL)
    for table_name, data in db_data.items():
        try:
            sheet = spreadsheet.worksheet(table_name)
            sheet.clear()
        except gspread.WorksheetNotFound:
            sheet = spreadsheet.add_worksheet(title=table_name, rows=1000, cols=26)
        sheet.update(values=data, range_name="A1")

if __name__ == "__main__":
    while True:
        update_google_sheets()
        time.sleep(60)
