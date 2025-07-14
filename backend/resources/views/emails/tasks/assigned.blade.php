<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Task Assigned</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .email-header {
            background-color: #4a6baf;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .email-header img {
            max-height: 40px;
            margin-bottom: 10px;
        }

        .email-header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 600;
        }

        .email-body {
            padding: 30px 25px;
        }

        .email-body p {
            font-size: 15px;
            margin-bottom: 16px;
        }

        .task-box {
            background-color: #f9f9f9;
            border-left: 4px solid #4a6baf;
            padding: 16px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .task-box p {
            margin: 8px 0;
        }

        .task-label {
            font-weight: bold;
            color: #4a6baf;
            display: inline-block;
            width: 100px;
        }

        .deadline {
            color: #d9534f;
            font-weight: bold;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a6baf;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .email-footer {
            font-size: 13px;
            text-align: center;
            color: #777;
            padding: 20px;
            border-top: 1px solid #eaeaea;
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">

            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAeQAAAHkCAYAAADvrlz5AAAABHNCSVQICAgIfAhkiAAAABl0RVh0U29mdHdhcmUAZ25vbWUtc2NyZWVuc2hvdO8Dvz4AAAAtdEVYdENyZWF0aW9uIFRpbWUATW9uIDE0IEp1bCAyMDI1IDAzOjE2OjA4IFBNIEVBVEP9lj4AACAASURBVHic7d17mM4F/v/x1xw0TjOibZxGzofFaBaz5DTRYBCppNhkjDZpKV2bJBctHVToREZiJKek3agp2WRtwlJKhGQ1KqvDSjsOMxjM749+5uuezz0z9z1zz3zeM/N8XJfr6v7MfX/u94wrz/l87s8haPfu3dkCAACuiIyMVGRkpELXr1+vadOmuT0PAADlypQpUxQfH5/zONjFWQAAwP9HkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAA0LdHgDuqFKliho3bqyQkBB99dVXOnXqlNsjAUC5RpDLuAYNGig6OlotW7ZU48aN1aBBAzVs2FBXXHGFx/MmTZqk5ORkv9adkJCgSZMmqVWrVjp27JgOHjyob775RocOHVJaWpoOHjyoL774QhkZGYH8lgCgTCLIZUjlypXVo0cPdenSRW3atFGrVq0UHh7u02sff/xxnTx5UkuWLPHp+UOHDtWcOXNyHteoUUM1atRQbGys47lff/21du3apd27d2v37t3avHmzMjMzffumAKCcIMilXNOmTRUfH69evXopLi6uSOuaNm2aT0GuUaOGR4wL0qhRIzVq1EgDBw7MWbZhwwatX79e7777rr799ttCzQsAZQlBLqX69++ve++9V+3atQvYOqtVq6ZmzZrpq6++yvd5gXjPHj16qEePHnriiSe0f/9+vfrqq3rllVfYcgZQbnGUdSlSsWJFJSUlaceOHVq8eHFAY3xRjRo1CnxOZGRkQN+zefPmevzxx7V3715NnjzZ8fk2AJQHBLkUiIiI0Pjx47V7927NnDlTDRs2dHukYlGtWjXdf//9OnDggJ555pky+30CgDcE2bArrrhCU6ZM0e7duzVx4sRyteWYmJiojz/+WAsWLFDz5s3dHgcAih1BNqhy5cqaPn26Dhw4oHHjxvl8pHRJyc7OLpH3CQ4O1k033aStW7dqxYoVat26dYm8LwC4gSAb07lzZ23btk2jRo1ye5Q8BQUFlfh79u7dW//4xz80efJkVahQocTfHwCKG0E2omLFipo5c6beeust1a1b1+1xTAoJ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WTmPjx8/rgYNGhT43mPGjNG0adM8lu3atUu9evXS2bNnc5bFxMQU6o5sU6ZM0Zw5c3IeL1iwQDfddFPO4y+++ELdunXze73e1K5dW3379lWnTp3UokUL1a1bV1WqVNHZs2f1888/Ky0tTZ988onef/99/etf//JpnS+++KKGDBmS8/jcuXNq2bKljh496vd8ffv21alTp/TPf/7T79c2b95cW7du9Vj23HPPOf7ukD+CDA+FjVBJCQkJ0W233aZx48apcePGbo9jSkhIiO655x5VqFBBycnJHsEqjOjoaD311FNed/9XqFBBERERatq0qQYPHqy0tDRNnDhRf//734v0npdq166dJk+e7LHs+PHjSkxMLPL3VpJatGih8ePHa+DAgQoKCnJ8vVKlSoqKilJUVJS6du2q+++/XwcPHtSMGTP0xhtv6MKFC3mue9myZR5BDg0N1U033aT58+f7Peddd92lEydOFCrIt956q2PZ8uXL/V5Pecd5yAU4fPiw2yNAUlhYmP74xz/qs88+0+zZs4mxFzfffLOioqJUs2ZNj3+kC6NLly5at26dz5/FN2zYUK+99pratWtXpPe9qFq1akpJSVGFChU8lo8ZM0aHDh0KyHsUt7CwMM2aNUsfffSRbrzxRq8xzkvjxo01b948bdmyRa1bt87zeVu2bHH8PAYPHuz3rE2bNlW3bt2UkJCgOnXq+P36QYMGeTzevn27/v3vf/u9nvKOIBeAILvvtttu0+7du/XUU08pKiqqxN43dwx8debMGZ06dcrrn4yMDMfzT58+nefzMzMzfX7fe++9N+e/x44d61cALtWkSRMtX75cFStW9Ot127Zt044dOwr1nrnNmTNH9erV81iWnJys1NRUn9eRnp6uY8eO5fvH299HINSrV0/vvfeeRowYoeDgwv8z26xZM61bt0633XZbns9ZsWKFx+O2bduqSZMmfr3PyJEjJf26lyUxMdGv13bu3Nnx/yVbx4XDLusCEGT3XHHFFUpOTlZ8fLwr75+VlVWo102dOlVTp071+rV69eo5PqMfMmRIoXYTXqpXr15q2bJlzuNGjRppwIABWrNmjd/rmjhxoqpWreqxbM+ePZo9e7b27NmjY8eO6corr1SnTp00ZMgQRUdHKzs7O2D3xh41apT69evnsezjjz/WI4884td6+vfv78oFXiIjI/XOO+94/eXxxIkTeuedd7Rx40Z99dVXSk9PV8WKFVWnTh21a9dOAwYM8Ph7lH7dpT137lyFhoZq6dKljnWuWLFCDz30kMcvYIMHD9YTTzzh07yVK1f2CP6wYcP09NNP69y5cz69PvcWeWZmpt58802fXgtPbCEXoDh/i0beBg4cqH/961+uxbi0ue+++3xaVpCwsDD17dvXY9n69esVFxen119/XXv27NH333+vXbt2ad68eYqLi9OYMWOUkpKinTt3Fnr+i2JiYhy/zBw7dkxJSUk+B8JNFStW1PLlyx0xPnfunJ577jlFR0frnnvu0euvv66dO3cqLS1N+/bt0wcffKCnn35aXbp00S233KKDBw861j1r1ix16dLFsfzw4cPatGmTx7JbbrnF55kHDx6siIiInMc1a9bU9ddf79Nrw8LCdMMNN3gsS01N1YkTJ3x+f/wfguyDb7/91u0Ryo2IiAgtWLBAKSkpuuKKK1ydpbC7rEtabGysrrnmGsfymJgYXXvttX6tq1mzZgoLC/NYNmPGjHwPLFq+fLnGjx/v1/t4ExERoZSUFF122WU5y7Kzs3X33XfrP//5T5HXXxImTZqktm3beixLT0/XwIEDNW3aNB0/frzAdXzwwQeKi4tzHCBXoUIFLVy40LH3QnLuIq5fv77Pn/8nJSU5ll3chV2QhIQEj5h7mwW+I8g+KC2nAZV27du31+bNmz1OO3FTYXdZl7T8toT93UquXr26Y9nXX3/t90yF8fzzzztOhXr22WdLzWVdo6KidOedd3osO3v2rIYMGaItW7b4ta6MjAwNGzbMcfrTlVdeqT/96U+O57/99tuO2PuyldyxY0evB4117txZzZs3L/D1uXdXHz58WB9++GGBr4N3BNkHn3zyidsjlGnBwcGaMGGC1q5dq7p167o9TqnStGlT9enTJ+dxVlaWTp48mfM4Li5OMTExPq/P2y8hNWvWLNqQPhg5cqRj1+fmzZt9/hzUgokTJ3rdu+DrOcW5ZWVl6a677vL4+5SkP/3pT6pRo4bHsszMTMfxAjfeeGOBe3m8bR1fVNBWcvXq1R0fKb322mvKzs7O93XIG0H2QaCOHIVT5cqV9eabb2rChAkKCQlxexwPpWGX9b333utxMM/q1au1cuVKj+f4s5Xs7SDG4cOHF35AH7Ru3VqPPfaYx7KffvpJI0eOzHdXuSXh4eG68cYbPZb9+OOPmj17dpHWe/jwYc2bN89jWdWqVXXzzTc7npt7V/Hll1+uXr165bnu3/zmNxowYECeXx88eLCqVKmS59e9BZ/d1UVDkH3wxRdflJrdl6VJeHi4UlNT1bVrV7dH8cr633nt2rUduyXnz5+vhQsXeizr37+/z5d//e677xyf1955550aMWJE0YbNQ9WqVbVo0SKPLcvz58/rzjvv1E8//VQs71kcunfv7jhNbMmSJQG5gElKSopjqzP3UejSr6ed5T4YLL9zku+44w6Pz+uPHz/ucbW1iIiIfHd751731q1bS8054lYRZB+cO3eOreQAi4iI0LvvvuvX7lR4Gj16tMc/qDt27NCOHTv05ZdfavPmzTnLg4ODPc5RLsirr77q8TgoKEizZs3SzJkzvR5QVBTPPPOM4yIv06dP10cffRTQ9yluHTp0cCwL1I1JfvjhB8dxLO3bt/e6Ryn3FmqvXr1UrVo1x/OCg4Md5xsvX77cMXNeu7QbNGig3//+9x7Lli1bluf3AN8QZB9t3LjR7RHKjOrVq+u9995Tq1at3B6l1IqIiHDsSn7ppZdy/nvBggUeX7v11lt9/ix4zpw52rNnj2N5UlKStm7dqltvvbXQFx251PDhwx1XeFq/fr2eeeaZIq+7pDVr1szj8YULFwJ6DvSuXbs8HleuXNnrec4rV6702M0fFhamgQMHOp6XkJDgeP2iRYu0aNEij2WtW7f2+stG7q3jU6dOFeqcd3giyD5677333B6hTAgPD9e7776rFi1auD1KqTZy5EiFh4fnPP7hhx+0evXqnMepqakeu57DwsI0evRon9admZmpoUOH6ocffnB8rW7dukpOTtbGjRvVvXv3Qs9fqVIlTZ8+3bG8MDeIyMuHH36Y5xW6hg0bFrD3keS4Pev3338f0HuLe9sV7O0Sl0eOHHFsPHjbbZ37gK3NmzfrwIED+uCDD/TNN9/k+1zJeQT3W2+9pVOnTuU1PnxEkH20a9cuff/9926PUapVqlRJa9as8el0CuQtLCxMo0aN8li2cOFCjwtnnD9/XikpKR7PSUxMdJwzmpfvvvtO8fHxeV7sIzo6Wn/961+1bNmyQl3OtEKFCl4vzTlp0iSf7gJlTe5d+bmPjC4qbxfayOvjg9yX0uzYsaPHZUgbNWrkOD/90i3jxYsXe3xtwIABHtcEaN++veNjBnZXBwZB9gNbyYUXFhamVatW8ZlxAAwdOlSRkZE5j0+fPq1XXnnF8bzFixfr9OnTOY8jIiLyPc0ltyNHjqhnz5564IEH9N///tfrc/r06aPNmzcrISHB928gH1WqVNHcuXMDskvcTYE+9cfb+vJ6j9TUVKWnp+c8DgoK8tiiHTlypMfP9+jRo3r77bdzHi9dutTjYLTLLrvMY49C7i3ub775xu/zrOEdQfZDoA7SKI8WL16sTp06uT2GXyye9hQUFOS4MMQbb7yhn3/+2fHcY8eOadWqVR7LLt4v2VcXt7TbtWunGTNmeN3yCw8P17JlyzR06FCf13up3FfC69ixo9eLX/grMzMzz5t2BPoI+tw/F1/3RPjK2/ry2go/c+aM/vrXv3osuxjRihUrOu4EtmzZMo+fR+5AS7/uXQkKClJoaKjj9C5OdQocguyHDRs2eP2HD/mbMmVKvudDWmXxtKcBAwY4TmG69GCu3HJ/LTIyslDhPHnypKZPn66YmBi9+OKLHlve0q+/KDz//PNq3769X+tduHCh+vfv74jLpEmTivzRRu/evVWvXj2vf1577bUirTu33KeK1apVy++7ZeWnfv36Bb7npXLvtm7WrJliYmI0aNAgXX755TnLs7OzHbuoJTkO7rrqqqvUs2dPXXfddR67r7Ozsx3vhcIjyH44d+4cn5X4qXv37ho3bpzbY5QZuU9f2rRpk9cjoi/au3ev48YDY8aMKfQtAY8dO6bJkyere/fu2rt3r8fXQkJC/DpCevv27Xr44Yf13Xff6S9/+YvH18LCwpScnGzuYjF52b9/v8fj4OBgXX311QFbf+51nTx5Mt8gXzz97VKDBw92HKD1j3/8w+sBY1u2bHF8T0lJSY7d1Zs2beKOeAFEkP20YMECLg3no9q1azsOLELhdevWTb/73e88luW+ipM3uZ/TsGFDx2Uq/bV//371799fBw4c8FjeunVrxcbGFvj6M2fOKDExMWcvREpKiuMXh5iYGP35z38u0pwlxdvlMS+9pGlR1KxZ0xHk7du3F3gVs9x7AYYPH+5YT+4t4UvlPi4hPj7ecScwdlcHFkH20+HDh4t879ryICQkRMuWLfN6UQIUjrdLYC5btizPU3su/vG2V6cwt2bM7ZdffnFs2Uq/3pigIGfOnHGcVjV27FjHqTN//vOf1aZNmyLNWRI2btzomH3YsGGqXLlykded+yAsSXrnnXcKfN3KlSs9rrxVqVIlj69///33+R6oumLFCo9bzwYHB3scf3DixAnHZ80oGoJcCN6OaIWnBx54gCOqAyg6OrpI5/3m1qZNG/Xo0aPI67n0imAX5T4n11fffvut417IFSpU0Ny5cz2uSGZRRkaGXn/9dY9l1atX14MPPlik9datW9dxilt6errjoC1vfvzxR33wwQd5fn3p0qUewc7t+PHjevPNN/P8+urVq5WZmVngHPAdQS6E1NRUx646/J9WrVqVml2NpUUgtmiLY52nTp1yfIRz6fnQ/lqwYIEj8i1bttTEiRMLvc6SMmPGDI8tSunXOzPlviOSrypUqKD58+d7XABG+vU2lb7cV1nKe5fy+fPnHZdI9Sa/Xdrsrg48glwIFy5c0LRp09wew6SQkBAtWLBAoaGhbo9SZtSvX7/In/l607VrV7Vt2zbPr/miQ4cOjt2puU9j8tfYsWMdYRs7dqzj2snW/PDDD0pOTvZYFhISokWLFvkd5UqVKunVV1/VNddc47H8yJEj+R5Vn9vatWv1yy+/OJa///77+R4UdtGnn37q9X7wBw8e1LZt23yeA74hyIX0zjvv6LPPPnN7DHMefPBBrsQVYGPHjvU42jg7O1txcXFq0qSJX3+8HWTkbSs5Li5Oa9as0YoVKxzXaL5UrVq1NHPmTMdyb7ux/XHo0CE9+uijHsuCg4M1d+5cx+eg1jz99NPaunWrx7IqVarotdde02OPPebTMRXdunXTxo0b1bt3b4/lZ8+eVVJSkl+7ibOysvTGG284lue35Zubt4/o2DouHgS5CB5++GG3RzClcePGGj9+vNtjBIyFC4P85je/cVzIYf369dq9e3eBB3Pl/rNt2zbH0cD9+vVTkyZNch4HBQXlxLB3797aunWrVq1apaSkJMXGxio6Olp9+vTR9OnT9cknnziuSb5jx46A3FThpZdecoStUaNGjs+Yi1tQUJDCwsLy/XOprKwsDRs2zHE96ODgYN1zzz3atWuXXnjhBd1www1q3ry5IiMjFRUVpY4dO+ree+/Vhg0btHr1ajVt2tQxy7hx47R9+3a/v4fc8fzuu++0fv16n1+/atUqj13kFy5ccNxzG4HBfsUi2LZtm95++23179/f7VFMKA2f8/nDwoVBRo0a5dgqzH0nJ3+8/PLL6tixY87ji7dmvHh+89ChQ9W6deucrwcFBem6667TddddV+C6T506FdBjB8aMGaOPPvrI4/sfOXKkUlNT9eGHHwbsffLTqlWrAq9h36FDB49jSo4dO6Z+/fpp8eLFateuncdzw8PDdfvtt+v222/3eYbMzEzdd999Xrd0ffH5559r7969atmypaRfr5rnz6mbGRkZWrVqVc45zBs3btSRI0cKNQvyxxZyEU2cODHgF5IvjZo0aaKbbrrJ7THKlCpVqjgu5JCWlqb333+/0Ot86623HIEZPHiwatWqJenXSzQW5jz7rKwsJSYmOm4TqkhnDwAACQZJREFUWBRpaWl67LHHPJYFBQVpzpw5jgOdrDly5Ij69eunhQsXFni+cH7279+v3r17FzrGF13cSs7KytLSpUv9fv2lu7i5MlfxIchFdOTIET3++ONuj+E6b+ejomiGDx/ucZlD6ddLTRbF+fPnHZdKvOyyy3TPPfdIkpKTk9WjRw+tW7fO55Bs3bpVcXFx+Z5iU1jz5s1z7GaPiorSE088EfD3CrSzZ89q/Pjx6tSpk958802/ftH5+uuvNXr0aHXu3DkgHwG8/vrrysrK0rvvvquffvrJ79fv3btX27ZtU3p6ulJTU4s8D7wjyAHw0ksv5XmbuvLgt7/9reMKPiia0NBQx/2LMzIyCrV1k9srr7zi2B0/fPjwnAOOPv/8cw0ZMkQxMTF66KGHlJqaqkOHDunUqVM6e/as/vOf/2jHjh164YUXlJCQoH79+jku0xgo2dnZGjt2rONApj/84Q+Og56s+uqrrzRy5EhFR0frwQcf1OrVq7V//36dOHFCFy5c0OnTp3XkyBFt3rxZzz33nK6//nrFxsZq5cqVRdq6vtTRo0f1/vvv+3UwV24pKSn629/+FtD7PMNT0LPPPpvNKTxF16JFC23atKnUXHs3L3379vV6GcD8pKSkaODAgcU0kXuysrJUs2ZNt8cAUEZNmTJF8fHxioyMVGRkJFvIgfLll1/qqaeecnuMEle9enVdf/31bo8BAKUeQQ6gmTNnOi6QX9YlJiZyERAACACCHGCJiYmFOmiitBoxYoTbIwBAmUCQA+yXX37RHXfcEbCDMSzr2bOnoqKi3B4DAMoEglwMLt54vay75ZZb3B4BAMoMglxM5s+fryeffNLtMYpNcHCwevXq5fYYAFBmEORi9PTTT2vevHluj1EsOnXqpIiICLfHAIAygyAXs4cffrhM3hklISHB7REAoEwhyCVgzJgxPt0MvDTh3GMACCyCXELGjRtXZq553aBBA1111VVuj1HsLNx+EUD5QZBL0KxZs3TfffeV+lOiYmNj3R6hRFi4/SKA8oMgl7AlS5bo9ttvV0ZGhtujFFp5CTIAlCSC7IL33ntP1157rcdNzUuT3DddBwAUHUF2yb///W91795db7/9ttuj+CU0NFStW7d2ewwAKHMIsosyMjI0fPhw/eUvf3F7FJ+1adOm3BzsVF6+TwA2EGQDXnjhBXXt2rXYbvIeSHXr1nV7hBLDQV0AShJBNmLPnj3q1q2bnn32WZ0/f97tcfJUs2ZNt0cAgDKJIBty7tw5Pfroo+rZs6fZreVatWq5PQIAlEkE2aCdO3eqU6dOuuOOO7Rz5063x/EQGRnp9ggAUCYRZMNSU1PVo0cPDRo0SFu3bnV7HEnssgaA4kKQS4ENGzaoX79+6t69u5YsWeLqRUXK04FO//vf/9weAUA5QpBLkc8//1z33Xeffvvb3+rBBx/U/v37A/4e6enp+X794MGDAX9Pqz7++GO3RwBQjhDkUujEiRNasGCBrrnmGl133XWaPXu2Dh8+XOT1pqena9++ffk+Z/bs2Tp+/HiR38u6s2fPaurUqW6PAaAcIcil3GeffaZHHnlEbdq0UUJCgl566aVCH6H98MMPF/ico0ePqk+fPgH5BcCqo0ePqn///qX20qYASqdQtwdA4Gzfvl3bt2+XJFWsWFEtW7ZUmzZt1Lp1azVv3ly1a9fWlVdeqfDwcMdrH3jgAa1YscKn99m3b5/atGmjhg0bqnbt2goKCgro9+Gmn3/+2ewpZwDKNoJcRp0+fVqffvqpPv30U69fj4qKUmRkpLKzs/Xll18qMzPT7/dIS0tTWlpaUUcFAIggl1uHDx8u07udAaC04TNkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAEEGQAAAwgyAAAGEGQAAAwgyAAAGECQAQAwgCADAGAAQQYAwACCDACAAQQZAAADCDIAAAYQZAAADCDIAAAYQJABADCAIAMAYABBBgDAAIIMAIABBBkAAAMIMgAABhBkAAAMIMgAABhAkAEAMIAgAwBgAEEGAMAAggwAgAFBu3fvznZ7CAAAyqvIyEhFRkayhQwAgAVB2dnZbCEDAOCy/wcuHhDeQ6u8sgAAAABJRU5ErkJggg== "alt="TaskFlow Logo" style="max-height: 40px; margin-bottom: 10px;" />
            <h1>New Task Assigned</h1>
        </div>

        <div class="email-body">
            <p>Dear {{ $user->name }},</p>

            <p>A new task has been assigned to you in <strong>TaskFlow</strong>:</p>

            <div class="task-box">
                <p><span class="task-label">Title:</span> <span>{{ $task->title }}</span></p>
                <p><span class="task-label">Description:</span> {{ $task->description }}</p>
                <p><span class="task-label">Deadline:</span> <span
                        class="deadline">{{ $task->deadline->format('M d, Y H:i A') }}</span></p>
            </div>

            <p>Please log in to your dashboard to view the task details and update its status.</p>


            <p>If you have any questions, feel free to contact your manager.</p>

            <p>Best regards,<br /><strong>TaskFlow Team</strong></p>
        </div>

        <div class="email-footer">
            <p>This is an automated email. Please do not reply.</p>
            <p>&copy; {{ date('Y') }} TaskFlow. All rights reserved.</p>
        </div>
    </div>
</body>

</html>