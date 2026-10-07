<?php

namespace App\Http\Traits;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;

trait ResolvesActivePortfolio
{
    protected function activePortfolio(): ?Portfolio
    {
        $portfolioId = session('active_portfolio_id');

        if (!$portfolioId) {
            return null;
        }

        $query = Portfolio::where('id', $portfolioId);

        if (!Auth::user()?->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        return $query->first();
    }

    protected function requireActivePortfolio(): Portfolio
    {
        $portfolio = $this->activePortfolio();

        if (!$portfolio) {
            abort(404, 'No active portfolio selected. Create or select a portfolio first.');
        }

        return $portfolio;
    }

    protected function setActivePortfolio(Portfolio $portfolio): void
    {
        session(['active_portfolio_id' => $portfolio->id]);
    }
}
