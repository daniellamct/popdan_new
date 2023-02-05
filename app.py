# This file is part of POPDAN.
#
# POPDAN is free software: you can redistribute it and/or modify it
# under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# POPDAN is distributed in the hope that it will be useful, but
# WITHOUT ANY WARRANTY;without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
# General Public License for more details.
#
# You should have received a copy of the
# GNU General Public License along with POPDAN.
# If not, see <https://www.gnu.org/licenses/>.

import uvicorn
import aiosqlite
from blacksheep import Application, Request, Response

app = Application()


async def create_db():
    """Creates an sqlite db if not exists"""
    async with aiosqlite.connect("popdan.sqlite3") as conn:
        await conn.execute(
            "CREATE TABLE IF NOT EXISTS key_value("
            "key_int TEXT NOT NULL UNIQUE,"
            "value_int INTEGER)"
        )

        await conn.execute(
            sql="INSERT OR IGNORE INTO key_value("
                "key_int, value_int)"
                "VALUES(?, ?)",
            parameters=("popdan_clicks", 0)
        )

        await conn.commit()


async def popdan_get_clicks():
    """get clicks"""
    async with aiosqlite.connect("popdan.sqlite3") as conn:
        async with conn.execute("SELECT value_int FROM key_value") as res:
            return (await res.fetchone())[-1]


async def popdan_add_clicks():
    """add one click """
    async with aiosqlite.connect("popdan.sqlite3") as conn:
        await conn.execute(
            sql="UPDATE key_value SET value_int = "
                "value_int + 1 "
        )
        await conn.commit()


app.serve_files(
    "static",
    index_document="index.html",
    fallback_document="index.html",
)


@app.route("/api/get_clicks")
async def get_clicks():
    return await popdan_get_clicks()


@app.route("/api/add_clicks")
async def add_clicks(request: Request):
    """http wrapper for popdan_add_click()"""
    if request.headers.get(b"User-Agent")[0] == b"popdan":
        await create_db()
        await popdan_add_clicks()
        return Response(200)
    return Response(403)


if __name__ == '__main__':
    uvicorn.run(
        app=f"{__name__}:app",
        host="0.0.0.0",
        port=8080)
